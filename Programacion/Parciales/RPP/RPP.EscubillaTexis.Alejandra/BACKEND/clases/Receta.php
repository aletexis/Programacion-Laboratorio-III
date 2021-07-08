<?php
require './clases/AccesoDatos.php';
require './clases/IParte2.php';
require './clases/IParte3.php';
require './clases/IParte1.php';
class Receta implements IParte2, IParte3, IParte1
{

    public $id;
    public $nombre;
    public $ingredientes;
    public $tipo;
    public $pathFoto;

    public function __construct($_id = "", $_nombre, $_ingredientes, $_tipo, $_pathFoto = "")
    {
        $this->id = $_id;
        $this->nombre = $_nombre;
        $this->ingredientes = $_ingredientes;
        $this->tipo = $_tipo;
        $this->pathFoto = $_pathFoto;
    }

    public function ToJSON()
    {
        $p = new stdClass();
        $p->id = $this->id;
        $p->nombre = $this->nombre;
        $p->ingredientes = $this->ingredientes;
        $p->tipo = $this->tipo;
        $p->pathFoto = $this->pathFoto;
        return json_encode($p);
    }

    public function Agregar()
    {
        $objBD = AccesoDatos::DameUnObjetoAcceso();
        $consulta = $objBD->RetornarConsulta("INSERT INTO recetas ( nombre, ingredientes, tipo, path_foto)VALUES(?,?,?,?)");
        return $consulta->execute([$this->nombre, $this->ingredientes, $this->tipo, $this->pathFoto]);
    }

    public function Traer()
    {
        $lista = [];
        $objBD = AccesoDatos::DameUnObjetoAcceso();
        $consulta = $objBD->RetornarConsulta("SELECT * FROM recetas");
        $consulta->execute();

        while ($fila = $consulta->fetch()) {
            $nuevo = new Receta($fila[0], $fila[1], $fila[2], $fila[3], $fila[4]);
            array_push($lista, $nuevo);
        }
        return $lista;
    }

    function Existe($array)
    {
        $flag = false;
        foreach ($array as $key) {
            if ($this->nombre == $key->nombre && $this->tipo == $key->tipo) {
                $this->id = $key->id;
                $this->ingredientes = $key->ingredientes;
                $this->pathFoto = $key->pathFoto;
                $flag = true;
                break;
            }
        }
        return $flag;
    }

    function Modificar()
    {
        $objBD = AccesoDatos::DameUnObjetoAcceso();
        $consulta = $objBD->RetornarConsulta("UPDATE recetas SET nombre= ?, ingredientes= ?,tipo= ?,path_foto= ? WHERE id=?");
        return $consulta->execute([$this->nombre, $this->ingredientes, $this->tipo, $this->pathFoto, $this->id]);
    }

    function Eliminar()
    {
        $objBD = AccesoDatos::DameUnObjetoAcceso();
        $consulta = $objBD->RetornarConsulta("DELETE FROM recetas WHERE nombre=? AND tipo=?");
        return $consulta->execute([$this->nombre, $this->tipo]);
    }
    function GuardarEnArchivo()
    {
        $nombreArchivo = "./recetas_borradas.txt";
        $archivo = fopen($nombreArchivo, "a+");
        if ($archivo) {
            if ($this->pathFoto != null || $this->pathFoto != "") {
                $pathFoto = $this->pathFoto;
                $fechaActual = date("h:i:s");
                $fechaActual = str_replace(":", "", $fechaActual);
                $pathviejoM = "recetasModificadas/" . $pathFoto;
                $pathviejoI = "recetas/imagenes/" . $pathFoto;
                $imagennombre = strtolower(pathinfo($pathFoto, PATHINFO_EXTENSION));
                if (file_exists("./recetasModificadas/" . $pathFoto)) {
                    rename(chop($pathviejoM), chop("./recetasBorradas/" . $this->id . "." . $this->nombre . "." . "borrado" . "." . $fechaActual . "." . $imagennombre));
                }
                if (file_exists("./recetas/imagenes/" . $pathFoto)) {
                    rename(chop($pathviejoI), chop("./recetasBorradas/" . $this->id . "." . $this->nombre . "." . "borrado" . "." . $fechaActual . "." . $imagennombre));
                }
                $this->pathFoto = $this->id . "." . $this->nombre . "." . "borrado" . "." . $fechaActual . "." . $imagennombre;
            }
            
            fwrite($archivo, $this->id . "-" . $this->nombre . "-" . $this->ingredientes . "-" . $this->tipo . "-" . chop($this->pathFoto) . "\r\n");
            fclose($archivo);
        }
    }
    static function MostrarBorrados()
    {
        $archivo = fopen('./recetas_borradas.txt', "r");
        $datos = array();
        $listaBorrados = array();
        if ($archivo) {
            $archivito = filesize('./recetas_borradas.txt');
            if ($archivito != 0) {
                while (!feof($archivo)) {
                    $cadena = fgets($archivo);
                    $datos = explode('-', $cadena);
                    if (count($datos) > 2) {
                        $auxBorrada = new Receta($datos[0], $datos[1], $datos[2], $datos[3], $datos[4]);
                        array_push($listaBorrados, $auxBorrada);
                    }
                }
            }
            fclose($archivo);
        }
        return $listaBorrados;
    }
}

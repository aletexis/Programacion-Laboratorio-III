<?php

class Cocinero
{

    private $especialidad;
    private $email;
    private $clave;

    static $path="./archivos/cocinero.json";

    function __construct($especialidad,$email,$clave)
    {
        $this->especialidad=$especialidad;
        $this->email=$email;
        $this->clave=$clave;
    }
    public function _getespecialidad()
    {
        return $this->especialidad;
    }
    public function _setEspecialidad($especialidad)
    {
         $this->especialidad = $especialidad;
    }
    public function _getEmail()
    {
        return $this->email;
    }

    public function _getClave()
    {
        return $this->clave;
    }

    function ToJSON(){
        $obj= new stdClass();
        $obj->especialidad=$this->especialidad;
        $obj->email=$this->email;
        $obj->clave=$this->clave;
        return json_encode($obj);
    }

    function GuardarEnArchivo(){
        $arrayJson = array();
        $obj = new stdClass();
        $obj->exito = false;

        $obj->mensaje = "No se pudo Agregar"; 

        if (file_exists(Cocinero::$path)) {
            $arc = fopen(Cocinero::$path, "r+");
            $leo = fread($arc, filesize(Cocinero::$path));
            fclose($arc);
            $arrayJson = json_decode($leo);
            array_push($arrayJson, json_decode($this->ToJSON()));
            $arc = fopen(Cocinero::$path, "w+");
            $cant = fwrite($arc, json_encode($arrayJson));
            if ($cant > 0) {
                $obj->exito = true;

                $obj->mensaje = "Agregado Correctamente";
            }
            fclose($arc);
        } else {
            $arc = fopen(Cocinero::$path, "w+");
            array_push($arrayJson, json_decode($this->ToJSON()));
            $cant = fwrite($arc, json_encode($arrayJson));
            if ($cant > 0) {
                $obj->exito = true;
                $obj->mensaje = "Agregado Correctamente";
            }
            fclose($arc);
        }
        return $obj;
    }

    static function TraerTodos()
    {
        $traigoTodos = array();
        $archivo = fopen(Cocinero::$path, "r");
        $archAux = fread($archivo, filesize(Cocinero::$path));
        $traigoTodos = json_decode($archAux, true, 512, JSON_OBJECT_AS_ARRAY); //traigo los arrays de json
        fclose($archivo);
        $cantidad = count($traigoTodos);
        $array = [];
        for ($i = 0; $i < $cantidad; $i++) {
            $nuevo = new Cocinero($traigoTodos[$i]["especialidad"], $traigoTodos[$i]["email"], $traigoTodos[$i]["clave"]);
            array_push($array, $nuevo);
        }
        return $array;
    }

    public static function verificarExistencia($algo)
    {
        $traigoTodos = Cocinero::traerTodos();
        $obj = new stdClass();
        $cont = 0;
        $flag = 0;
        foreach ($traigoTodos as $value) {
            if ($value->_getEmail() == $algo->_getEmail()  && $value->_getClave() == $algo->_getClave()) {
                $obj->existe = true;
                $algo->_setespecialidad($value->_getespecialidad());
                $flag = 1;
                foreach ($traigoTodos as $valor) {
                    if ($valor->_getespecialidad() == $algo->_getespecialidad()) {
                        $cont++;
                    }
                }
                $obj->mensaje = "Cocineros con misma Especialidad :" . $cont;
                break;
            }
        }
        if ($flag == 0) {
            $obj->existe = false;
            $obj->mensaje = "Especialidades mas Populares: ";
            $obj->masPopulares=json_decode(Cocinero::masPopulares());
        }
        return $obj;
    }
    public static function masPopulares()
    {
        $traigoTodos = Cocinero::TraerTodos();
        $array=[];
        $output=[];
        
        foreach ($traigoTodos as $key) {
            $array[]=strtolower($key->_getespecialidad());
        }
        $array=array_count_values($array);
        $maximo=max($array);
        foreach ($array as $key => $value) {
            if($maximo==$value){
                $populares= new stdClass();
                $populares->nombre=$key;
                $populares->cant=$value;
                array_push($output,$populares);
            }
        }
        return json_encode($output);
    }

}
























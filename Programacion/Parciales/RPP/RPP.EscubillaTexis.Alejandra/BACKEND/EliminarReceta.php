<?php
require "./clases/Receta.php";

$nombre = $_GET["nombre"] ?? NULL;
$receta = $_POST["receta_json"] ?? NULL;
$accion = $_POST["accion"] ?? NULL;

$ubicacion="./recetasBorradas/";

$newaux = new Receta("", "", "", "");
if ($receta == NULL) {
    if ($nombre != NULL) {
        $lista = [];
        $lista = $newaux->Traer();
        $retorno = "NO Esta en la Base de Datos";
        foreach ($lista as $key) {
            if ($key->nombre == $nombre) {
                $retorno = "Esta en la Base de Datos";
                break;
            }
        }
        echo $retorno;
    } else {
        $listaBorrados = Receta::MostrarBorrados();
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Document</title>
            <style>
                table {

                    padding: 20px;
                    margin: 0 auto;
                    width: 900px;
                    text-align: center;
                }

                .trpapa {
                    height: 100px;
                }
            </style>
        </head>

        <body>
            <table>
                <th>
                    <h4>Listado Eliminado</h4>
                </th>
                <tr>
                    <td colspan="4">
                        <hr />
                    </td>
                </tr>
                <tr>
                    <th>Nombre</th>
                    <th>ingredientes</th>
                    <th>tipo</th>
                    <th>Foto</th>
                </tr>
                <?php foreach ($listaBorrados as $key) { ?>
                    <tr class="trpapa">
                        <td><?php echo $key->nombre ?></td>
                        <td><?php echo $key->ingredientes ?></td>
                        <td><?php echo $key->tipo ?></td>
                        <?php
                        $flag = false;
                        if ($key->pathFoto == "") {
                            echo '<td>SinFoto</td';
                        } else {
                            if (file_exists($ubicacion . chop($key->pathFoto))) {
                                echo "<td><img src=".$ubicacion . chop($key->pathFoto) . " height='100px' width='100px'></td>";
                            } else
                                echo '<td>SinFoto</td';
                        }
                        ?>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="4">
                        <hr />
                    </td>
                </tr>
            </table>
        </body>

        </html>

<?php }
} else {
    $receta=json_decode($receta);
    $js = new stdClass();
    if ($accion == "borrar") {
        $js->exito = false;
        $js->mensaje = "No se pudo borrar de la base de datos";
        $auxFake = new Receta($receta->id, "", "", "");
        $lista = $auxFake->Traer();
        $auxBorrar = null;
        foreach ($lista as $key) {
            if ($key->id == $auxFake->id) {
                $auxBorrar = new Receta($key->id, $key->nombre, $key->ingredientes, $key->tipo, $key->pathFoto);
                break;
            }
        }
        if ($auxBorrar->Eliminar()) {
            $js->exito = true;
            $js->mensaje = "Se ha Borrado de la clase y se a Guardado en Borrados";
            $auxBorrar->GuardarEnArchivo();
        }
        echo json_encode($js);
    }
}

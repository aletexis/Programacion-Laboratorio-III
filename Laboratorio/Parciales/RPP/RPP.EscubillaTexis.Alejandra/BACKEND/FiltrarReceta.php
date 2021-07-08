<?php
require "./clases/Receta.php";

$nombre = $_POST["nombre"] ?? NULL;
$tipo = $_POST["tipo"] ?? NULL;

$nombre==""?$nombre=NULL:"";
$tipo==""?$tipo=NULL:"";

$listado = [];
$recetaRandom = new Receta("", "", "", "");
$listado = $recetaRandom->Traer();
$nombretipo = false;
$nombreSolo = false;
$tipoSolo = false;

$ubicacion1 = "./recetas/imagenes/";
$ubicacion2 = "./recetasModificadas/";

if ($nombre != NULL && $tipo != NULL)
    $nombretipo = true;

if ($tipo == NULL)
    $nombreSolo = true;

if ($nombre == NULL)
    $tipoSolo = true;

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
    <th>
        <h4>Filtrado por <?php if ($nombretipo) {
                                echo "Nombre y tipo";
                            } else if ($nombreSolo) {
                                echo "Nombre";
                            } else if ($tipoSolo) {
                                echo "tipo";
                            } ?></h4>
    </th>
    <table>
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
        <?php
        if ($nombretipo) {
            foreach ($listado as $key) {
                if ($key->nombre == $nombre && $key->tipo == $tipo) { ?>
                    <tr class="trpapa">
                        <td><?php echo $key->nombre ?></td>
                        <td><?php echo $key->ingredientes ?></td>
                        <td><?php echo $key->tipo ?></td>
                        <?php
                        $flag = false;
                        if ($key->pathFoto == "") {
                            echo '<td>SinFoto</td';
                        } else {
                            if (file_exists($ubicacion1 . $key->pathFoto)) {
                                echo "<td><img src=./BACKEND/recetas/imagenes/" . $key->pathFoto . " height='100px' width='100px'></td>";
                                $flag = true;
                            }
                            if (file_exists($ubicacion2 . $key->pathFoto)) {
                                echo "<td><img src=./BACKEND/recetasModificadas/" . $key->pathFoto . " height='100px' width='100px'></td>";
                                $flag = true;
                            }
                            if ($flag == false) {
                                echo '<td>SinFoto</td';
                            }
                        }
                    }
                }
                echo '</tr>';
            } else if ($nombreSolo) {
                foreach ($listado as $key) {
                    if ($key->nombre == $nombre) { ?>
                    <tr class="trpapa">
                        <td><?php echo $key->nombre ?></td>
                        <td><?php echo $key->ingredientes ?></td>
                        <td><?php echo $key->tipo ?></td>
                        <?php
                        $flag = false;
                        if ($key->pathFoto == "") {
                            echo '<td>SinFoto</td';
                        } else {
                            if (file_exists($ubicacion1 . $key->pathFoto)) {
                                echo "<td><img src=./BACKEND/recetas/imagenes/" . $key->pathFoto . " height='100px' width='100px'></td>";
                                $flag = true;
                            }
                            if (file_exists($ubicacion2 . $key->pathFoto)) {
                                echo "<td><img src=./BACKEND/recetasModificadas/" . $key->pathFoto . " height='100px' width='100px'></td>";
                                $flag = true;
                            }
                            if ($flag == false)
                                echo '<td>SinFoto</td';
                        }

                        echo '</tr>';
                    }
                }
            } else if ($tipoSolo) {
                foreach ($listado as $key) {
                    if ($key->tipo == $tipo) { ?>
                    <tr class="trpapa">
                        <td><?php echo $key->nombre ?></td>
                        <td><?php echo $key->ingredientes ?></td>
                        <td><?php echo $key->tipo ?></td>
            <?php
                        $flag = false;
                        if ($key->pathFoto == "") {
                            echo '<td>SinFoto</td';
                        } else {
                            if (file_exists($ubicacion1 . $key->pathFoto)) {
                                echo "<td><img src=./BACKEND/recetas/imagenes/" . $key->pathFoto . " height='100px' width='100px'></td>";
                                $flag = true;
                            }
                            if (file_exists($ubicacion2 . $key->pathFoto)) {
                                echo "<td><img src=./BACKEND/recetasModificadas/" . $key->pathFoto . " height='100px' width='100px'></td>";
                                $flag = true;
                            }
                            if ($flag == false)
                                echo '<td>SinFoto</td';
                        }

                        echo '</tr>';
                    }
                }
            } ?>
                    <tr>
                        <td colspan="4">
                            <hr />
                        </td>
                    </tr>
    </table>
</body>
</body>

</html>

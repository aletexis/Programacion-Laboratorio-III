<?php
require "./clases/Receta.php";
$random = new Receta("", "", "", "");
$array = $random->MostrarBorrados();
$pathPhoto="./recetasBorradas/";
$title="Listado Recetas Borradas";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <h4><?php echo $title ?></h4>
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
        <?php foreach ($array as $key) { ?>
            <tr class="trpapa">
                <td><?php echo $key->nombre ?></td>
                <td><?php echo $key->ingredientes ?></td>
                <td><?php echo $key->tipo ?></td>
                <?php
                $flag = false;
                if (chop($key->pathFoto) == "") {
                    echo '<td>SinFoto</td';
                } else {
                    if (file_exists(chop($pathPhoto . $key->pathFoto))) {
                        echo "<td><img src=./BACKEND/recetasBorradas/" . $key->pathFoto . " height='100px' width='100px'></td>";
                        $flag = true;
                    }
                    if ($flag == false)
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
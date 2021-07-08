<?php
require "./clases/Receta.php";
$random = new Receta("", "", "", "");
$array = $random->Traer();
$pathPhoto = "./recetas/imagenes/";
$pathPhoto2="./BACKEND/recetas/imagenes/";
$pathPhotoMod = "./recetasModificadas/";
$pathPhotoMod2 = "./BACKEND/recetasModificadas/";

foreach ($array as $key) {
    if ($key->pathFoto != "" || $key->pathFoto != null) {
        if (file_exists($pathPhoto . $key->pathFoto)) {
           $key->pathFoto= $pathPhoto2 . $key->pathFoto;
            $flag = true;
        }
        if (file_exists($pathPhotoMod . $key->pathFoto)) {
            $key->pathFoto= $pathPhotoMod2 . $key->pathFoto;
            $flag = true;
        }
    }
}


echo json_encode($array);
/* 
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
    <title><?php echo $title ?></title>
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
            <th>nombre</th>
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
                if ($key->pathFoto == "") {
                    echo '<td>SinFoto</td';
                } else {
                    if (file_exists($pathPhoto . $key->pathFoto)) {
                        echo "<td><img src=".$pathPhoto2 . $key->pathFoto . " height='100px' width='100px'></td>";
                        $flag = true;
                    }
                    if (file_exists($pathPhotoMod . $key->pathFoto)) {
                        echo "<td><img src=". $pathPhotoMod2 . $key->pathFoto . " height='100px' width='100px'></td>";
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

</html> */
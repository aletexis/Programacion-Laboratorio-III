<?php

$op = isset($_POST["op"]) ? $_POST["op"] : null;


switch ($op) {

    case "subirFoto":

        $Ok = "false";

        $destino = "./fotos/" . date("Ymd_His") . ".jpg";
        
        if(move_uploaded_file($_FILES["foto"]["tmp_name"], $destino) ){
            $Ok = "true" . "-" . $destino;
        }

        echo $Ok;

        break;

    default:
        echo ":(";
        break;
}
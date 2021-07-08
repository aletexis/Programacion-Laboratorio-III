<?php
require "./clases/Receta.php";
$nombre = $_POST["nombre"] ?? NULL;
$ingredientes = $_POST["ingredientes"] ?? NULL;
$tipo= $_POST["tipo"] ?? NULL;

$ubicacion="./recetas/imagenes/";

$fake = new Receta("", $nombre,"", $tipo, "");
$array = $fake->Traer();

$json= new stdClass();
if ($fake->Existe($array)) {
    $json->exito=false;
    $json->mensaje= "El Receta ya Existe en la Base de Datos!";
} else {
    $pathFoto = $ubicacion . $_FILES["foto"]["name"];
    $imagen = strtolower(pathinfo($pathFoto, PATHINFO_EXTENSION));
    $fechaActual = date("h:i:s");
    $fechaActual = str_replace(":", "", $fechaActual);
    $tipofoto=str_replace(" ","",$tipo);
    $_FILES["foto"]["name"] = $nombre . "." . $tipofoto . "." . $fechaActual . "." . $imagen;
    $pathFoto = $ubicacion . $_FILES["foto"]["name"];
    move_uploaded_file($_FILES["foto"]["tmp_name"], $pathFoto);
    $newaux = new Receta("",$nombre,$ingredientes,$tipo,$_FILES["foto"]["name"]);
    $flag=$newaux->Agregar();
    if($flag){
    $json->exito=$flag;
    $json->mensaje="La Receta a sido Agregada!";
    }
}

echo json_encode($json);
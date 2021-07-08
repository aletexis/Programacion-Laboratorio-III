<?php
require "./clases/Receta.php";

$ubicacion = "./recetasModificadas/";
$ubicaion2 = "./recetas/imagenes/";

$aux = json_decode($_POST["receta_json"]);
$pathFoto = $ubicacion . $_FILES["foto"]["name"];
$fechaActual = date("h:i:s");
$fechaActual = str_replace(":", "", $fechaActual);
$imagen = strtolower(pathinfo($pathFoto, PATHINFO_EXTENSION));
$p = new stdClass();
/* 
if (file_exists($ubicacion . $Receta->foto)) {

    unlink($ubicacion . $Receta->foto);

}
if (file_exists($ubicaion2 . $Receta->foto)) {

    unlink($ubicaion2 . $Receta->foto);

} */
$tipofoto1=str_replace(" ","",$aux->tipo);
$aux->foto = $aux->nombre. "." . $tipofoto1 . "." . "modificado" . "." . $fechaActual . "." . $imagen;
$auxnueva = new Receta($aux->id, $aux->nombre, $aux->ingredientes, $aux->tipo, $aux->foto);

if ($auxnueva->Modificar()) {
    $tipofoto=str_replace(" ","",$auxnueva->tipo);
    $_FILES["foto"]["name"] = $ubicacion . $auxnueva->nombre . "." . $tipofoto . "." . "modificado" . "." . $fechaActual . "." . $imagen;
    move_uploaded_file($_FILES["foto"]["tmp_name"], $_FILES["foto"]["name"]);
    $p->exito = true;
    $p->mensaje = "Receta Modificada con Exito!";

} else {

    $p->exito = false;
    $p->mensaje = "No pudo ser Modificada";

}

echo json_encode($p);

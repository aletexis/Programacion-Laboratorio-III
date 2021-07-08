<?php
require "./clases/Receta.php";

$nombre=$_POST["nombre"]??NULL;
$ingredientes=$_POST["ingredientes"]??NULL;
$tipo=$_POST["tipo"]??NULL;

$sinFoto= new Receta("",$nombre,$ingredientes,$tipo);

$p = new stdClass();

if($sinFoto->Agregar()){
        $p->exito = true;
        $p->mensaje = "Agregada Correctamente";
}else{
        $p->exito = false;
        $p->mensaje = "NO Agregada";
}
echo json_encode($p);
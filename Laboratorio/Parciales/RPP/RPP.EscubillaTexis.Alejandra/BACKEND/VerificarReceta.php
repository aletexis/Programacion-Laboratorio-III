<?php
require "./clases/Receta.php";
$aux = $_POST["receta"] ?? NULL;
if ($aux != NULL) {
    $aux = json_decode($aux);

    $aux = new Receta("", $aux->nombre,"", $aux->tipo);
    $array = $aux->Traer();
    if ($aux->Existe($array)) {
        echo $aux->ToJSON();
    } else {
        $respuesta="No coinciden en Ambos";
        foreach ($array as $key) {
            if($key->nombre==$aux->nombre){
                $respuesta="No coinciden en tipo";
            }
            if($key->tipo==$aux->tipo){
                $respuesta="No coinciden en nombre";
            }
        }
        echo $respuesta;
    }
}

<?php
require_once "namespace/varios.php";

use mi_namespace\ {
    Clase,
    function funcion,
    const CONSTANTE
};


$obj_1 = new Clase();

echo Clase::test() . "<br/>";

$valor = CONSTANTE;

echo "<br/>" . $valor . "<br/>";

echo funcion();

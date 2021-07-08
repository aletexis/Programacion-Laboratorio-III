<?php
require_once "namespace/varios.php";

$obj = new mi_namespace\Clase();

echo mi_namespace\Clase::test() . "<br/>";

echo mi_namespace\funcion();

$valor = mi_namespace\CONSTANTE;

echo "<br/>" . $valor;

//echo "<br/>" . "namespace actual: " . __NAMESPACE__;

/*
//ERROR

$otroValor = CONSTANTE;

echo funcion();

$obj_1 = new clase();
*/
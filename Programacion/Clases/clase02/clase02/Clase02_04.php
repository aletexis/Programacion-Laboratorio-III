<?php
require_once "clases/test.php";
require_once "clases/clase_abstracta.php";
require_once "clases/clase.php";
require_once "clases/i_mostrable.php";
require_once "clases/otro_test.php";


//--------------------------------------------------------------------------------//

//CREO UN OBJETO
$obj = new Test();

//UTILIZO METODO DE INSTANCIA
echo $obj->mostrar();
echo "<br/>";
//$obj->formatearCadena("hola mundo");//ES PRIVADO

//ACCEDO A LOS ATRIBUTOS
//$obj->cadena = "otro valor";//ES PRIVADO
$obj->entero = 3;
$obj->flotante = 6.15;

//UTILIZO METODO DE CLASE
echo Test::mostrarTest($obj);
echo "<br/>";

//--------------------------------------------------------------------------------//
/*
$otroObj = new OtroTest();

//UTILIZO METODO DE INSTANCIA
echo $otroObj->mostrar();
echo "<br/>";

//UTILIZO METODO DE CLASE
echo OtroTest::mostrarTest($otroObj);
echo "<br/>";

//ACCEDO A ATRUBUTO ESTATICO
OtroTest::$att = "valor pasado";
echo OtroTest::$att;

//UTILIZO METODO DE INTERFACE
$otroObj->mostrarMensaje();

*/
//--------------------------------------------------------------------------------//
/*
$oobj = new Clase("valor padre", "valor hijo");

echo $oobj->getAtributo();
echo "<br/>";
echo $oobj->otroAtributo;
echo "<br/>";

echo $oobj->metodoAbstracto();
*/
//--------------------------------------------------------------------------------//

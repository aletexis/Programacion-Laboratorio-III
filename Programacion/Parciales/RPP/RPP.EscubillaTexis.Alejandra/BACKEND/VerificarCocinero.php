<?php
require "./clases/Cocinero.php";

$email = $_POST["email"] ?? NULL;
$clave = $_POST["clave"] ?? NULL;
$aux = new Cocinero("", $email, $clave);
$validar = Cocinero::verificarExistencia($aux);
$resp = new stdClass();
if ($validar->existe) {
    $resp->exito = true;
    $cookieNombre = $aux->_getEmail() . "_" . $aux->_getespecialidad();
    $cookieValor = date("H:i:s") . $validar->mensaje;
    setcookie($cookieNombre, $cookieValor,);
    $resp->mensaje = "Encontrado\n" . $validar->mensaje;
} else {

    $resp->exito = false;
    $resp->mensaje = "No se encontro, ". $validar->mensaje;
    $resp->masPopulares=$validar->masPopulares;
}
echo json_encode($resp);

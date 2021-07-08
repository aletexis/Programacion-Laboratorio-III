<?php
    /* AltaCocinero.php: Se recibe por POST la especialidad, el email y la clave. Invocar al método GuardarEnArchivo.*/
    
    require "./clases/Cocinero.php";

    $especialidad = isset($_POST["especialidad"]) ? $_POST["especialidad"] : NULL;
    $email = isset($_POST["email"]) ? $_POST["email"] : NULL;
    $clave = isset($_POST["clave"]) ? $_POST["clave"] : NULL;

    $obj = new stdClass();

    if($especialidad != NULL && $email != NULL && $clave != NULL)
    {
        $nuevo = new Cocinero($especialidad, $email, $clave);
        $obj = $nuevo->GuardarEnArchivo();

    }

    echo json_encode($obj);

?>

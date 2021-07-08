<?php
    session_start();
    function ValidarSesion($path)
    {
        if(!isset($_SESSION["DNIEmpleado"]))
        {
           header("Location: $path");
        }
    }
?>
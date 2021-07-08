<?php
    session_start();
    function ValidarSesion($path)
    {
        if(!isset($_SESSION["DNIEmpleadoBD"]))
        {
           header("Location: $path");
        }
    }
?>
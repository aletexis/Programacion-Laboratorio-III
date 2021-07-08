<?php
    require_once("empleado_bd.php");
    require_once("fabrica_bd.php");
    require_once("accesoDatos.php");

    $dni = isset($_POST["dni"]) ? $_POST["dni"] : 0;
    $apellido = isset($_POST["apellido"]) ? $_POST["apellido"] : 0;
    $flag = false;

    $accesoDatos = AccesoDatos::ObjetoAccesoDatos();

    $sql = "SELECT dni, apellido FROM empleados WHERE dni = :dni AND apellido = :apellido";

    $query = $accesoDatos->RetornarConsulta($sql);

    $dni = intval($dni);

    $query->bindValue(':dni', $dni, PDO::PARAM_INT);
    $query->bindValue(':apellido', $apellido, PDO::PARAM_STR);

    try
    {
        $query->execute();
        $empleado = $query->FetchObject();
    }
    catch(PDOException $e)
    {
        echo "Error! {$e->getMessage()}";
    }

    if($empleado != false)
    {
        if($dni == $empleado->dni && $apellido == $empleado->apellido)
        {
            $flag = true;
        }

        if($flag)
        {
            session_start();
            $_SESSION["DNIEmpleadoBD"] = $dni;
            header("Location: ../ajax_bd.php");
        }
        else
        {
            echo "Error! No se pudo encontrar un empleado con los datos ingresados.<br><a href=../login_bd.html>Login</a>";
        }
    }
    else
    {
        echo "Error! No se pudo encontrar un empleado con los datos ingresados.<br><a href=../login_bd.html>Login</a>";
    }
?>
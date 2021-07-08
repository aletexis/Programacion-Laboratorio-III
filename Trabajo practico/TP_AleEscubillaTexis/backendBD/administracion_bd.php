<?php
    require_once("empleado_bd.php");
    require_once("fabrica_bd.php");
    require_once("accesoDatos.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        <?php
            $dni = isset($_POST["txtDni"]) ? $_POST["txtDni"] : 0;
            $nombre = isset($_POST["txtNombre"]) ? $_POST["txtNombre"] : 0;
            $apellido = isset($_POST["txtApellido"]) ? $_POST["txtApellido"] : 0;
            $sexo = isset($_POST["cboSexo"]) ? $_POST["cboSexo"] : 0;
            $legajo = isset($_POST["txtLegajo"]) ? $_POST["txtLegajo"] : 0;
            $turno = isset($_POST["rdoTurno"]) ? $_POST["rdoTurno"] : 0;
            $sueldo = isset($_POST["txtSueldo"]) ? $_POST["txtSueldo"] : 0;
            $file = isset($_FILES["file"]) ? $_FILES["file"] : 0;
            $modificar = isset($_POST["hdnModificar"]) ? $_POST["hdnModificar"] : 0;

            switch($turno)
            {
                case "0":
                    $turno = "M";
                    break;
                case "1":
                    $turno = "T";
                    break;
                case "2":
                    $turno = "N";
                    break;
            }

            $pathDestino = "../fotosBD/" . $file["name"];

            $empleado = new Empleado($nombre,$apellido,$dni,$sexo,$legajo,$sueldo,$turno);
            $fabrica = new Fabrica("X",7);
            $fabrica->TraerDeBaseDeDatos();
            $empleadoModificar = NULL;
            $fotoOk = FALSE;
            $condicionesFotoOk = FALSE;
            $dniDelEmpleadoModificar = NULL;

            if($modificar == "ok")
            {
                foreach($fabrica->GetEmpleados() as $item)
                {
                    if($item->GetDni() == $dni)
                    {
                        $empleadoModificar = $item;
                    }
                }
            }

            if(getimagesize($file["tmp_name"]) != FALSE)
            {
                $tipoDeArchivo = pathinfo($pathDestino,PATHINFO_EXTENSION);
                $apellido = str_replace(' ','',$apellido);
                $pathDestino = "../fotosBD/" . $dni . "-" . $apellido . "." . $tipoDeArchivo;

                if($tipoDeArchivo == "jpg" || $tipoDeArchivo == "bmp" || $tipoDeArchivo == "gif" || $tipoDeArchivo == "png" || $tipoDeArchivo == "jpeg")
                {
                    if($file["size"] <= 1000000)
                    {
                        $condicionesFotoOk = TRUE;
                    }
                }

                if(!file_exists($pathDestino) && $condicionesFotoOk)
                {
                    $fotoOk = TRUE;
                }

                if($empleadoModificar != NULL && $condicionesFotoOk)
                {
                    $fotoOk = TRUE;
                }
            }
            
            if($fotoOk)
            {
                $empleado = new Empleado($nombre,$apellido,$dni,$sexo,$legajo,$sueldo,$turno);
                move_uploaded_file($file["tmp_name"],$pathDestino);
                $empleado->SetPathFoto($pathDestino);
                
                if($modificar == "ok")
                {
                    if($empleadoModificar->GetApellido() !== $empleado->GetApellido())
                    {
                        unlink($empleadoModificar->GetPathFoto());
                    }
                    $fabrica->ModificarDeBaseDeDatos($empleado);
                }
                else
                {
                    if($fabrica->AltaBaseDeDatos($empleado))
                    {
                        echo "<a href='mostrar.php'>Mostrar empleados</a>";
                    }
                    else
                    {
                        unlink($empleado->GetPathFoto());
                        echo "Limite de empleados alcanzado <br>
                              <a href=./mostrar.php>Mostrar Empleados</a>";
                    }
                }
            }
            else
            {
                echo "Hubo un error con la foto <br> <a href='../indexArchivo.php'>Alta de empleados</a>";
            }
        ?>
    </div>
</body>
</html>
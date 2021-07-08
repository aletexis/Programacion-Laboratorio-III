<?php
    require_once("empleado.php");
    require_once("fabrica.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administracion</title>
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

            $pathDestino = "../fotos/" . $file["name"];
            $path = "../archivos/empleados.txt";

            if(!file_exists($path))
            {
                $archivo = fopen($path, "w");
                fclose($archivo);
            }

            $empleado = new Empleado($nombre, $apellido, $dni, $sexo, $legajo, $sueldo, $turno);
            $fabrica = new Fabrica(" ",7);
            $empleadoModificar = NULL;
            $fotoOk = false;
            $condicionesFotoOk = false;

            if($modificar == "ok")
            {
                $fabrica->TraerDeArchivo($path);
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
                $extension = pathinfo($pathDestino,PATHINFO_EXTENSION);
                $apellido = str_replace(' ', '', $apellido);
                $pathDestino = "../fotos/" . $dni . "-" . $apellido . "." . $extension;

                if($extension == "jpg" || $extension == "bmp" || $extension == "gif" || $extension == "png" || $extension == "jpeg")
                {
                    if($file["size"] <= 1000000)
                    {
                        $condicionesFotoOk = true;
                    }
                }

                if(!file_exists($pathDestino) && $condicionesFotoOk)
                {
                    $fotoOk = true;
                }
                
                if($empleadoModificar != NULL && $condicionesFotoOk)
                {
                    $fabrica->EliminarEmpleado($empleadoModificar);
                    $fabrica->GuardarArchivo($path);
                    unlink($empleadoModificar->GetPathFoto());
                    $fotoOk = true;
                }
            }
            
            if($fotoOk)
            {
                $empleado = new Empleado($nombre, $apellido, $dni, $sexo, $legajo, $sueldo, $turno);
                $fabrica->TraerDeArchivo($path);
                move_uploaded_file($file["tmp_name"],$pathDestino);
                $empleado->SetPathFoto($pathDestino);

                if($fabrica->AgregarEmpleado($empleado))
                {
                    $fabrica->GuardarArchivo($path);
                    echo "<a href='mostrar.php'>Mostrar empleados</a>";
                }
                else
                {
                    unlink($empleado->GetPathFoto());
                    echo "Error! No se pudo agregar el empleado.<br><a href=./mostrar.php>Mostrar Empleados</a>";
                }
            }
            else
            {
                echo "Error! La foto es invalida<br><a href='../indexArchivo.php'>Alta de empleados</a>";
            }
        ?>
    </div>
</body>
</html>
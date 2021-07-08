<?php
    require_once("fabrica.php");
    require_once("empleado.php");

    $legajo = isset($_GET["legajo"]) ? $_GET["legajo"] : 0;

    $path = "../archivos/empleados.txt";
    $archivo = fopen($path, "r");

    $fabrica = new Fabrica(" ",7);
    $fabrica->TraerDeArchivo($path);

    foreach($fabrica->GetEmpleados() as $item)
    {
        if($item->GetLegajo() == $legajo)
        {
            if($fabrica->EliminarEmpleado($item))
            {
                unlink($item->GetPathFoto());
                $fabrica->GuardarArchivo($path);
                echo "Empleado eliminado exitosamente<br><a href='mostrar.php'>Mostrar empleados</a>";
                break;
            }
            else
            {
                echo "Error! No se pudo eliminar el empleado<br><a href='../indexArchivo.php'>Alta de empleados</a>";
                break;
            }
        }
    }

?>
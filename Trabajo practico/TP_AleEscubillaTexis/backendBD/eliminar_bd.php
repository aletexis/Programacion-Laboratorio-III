<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar empleados</title>
</head>
<body>
    <?php
        require_once("fabrica_bd.php");
        require_once("empleado_bd.php");

        $legajo = isset($_GET["legajo"]) ? $_GET["legajo"] : 0;

        $fabrica = new Fabrica(" ",7);
        $fabrica->TraerDeBaseDeDatos();
        
        foreach($fabrica->GetEmpleados() as $item)
        {
            if($item->GetLegajo() == $legajo)
            {
                if($fabrica->EliminarDeBaseDeDatos($item))
                {
                    echo "Empleado eliminado con exito <br><a href='mostrar.php'>Mostrar empleados</a>";
                    break;
                }
                else
                {
                    echo "No se pudo eliminar <br><a href='../indexArchivo.php'>Alta de empleados</a>";
                    break;
                }
            }
        }
    ?>    
</body>
</html>
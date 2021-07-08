<?php
    require_once("fabrica.php");
    include_once("validarSesion.php");
    
    ValidarSesion("../login.html");
    
    if(file_exists("../archivos/empleados.txt"))
    {
        $path = "../archivos/empleados.txt";
    }
    
    $archivo = fopen($path,"r");
    $fabrica = new Fabrica(" ", 7);
    $fabrica->TraerDeArchivo($path);
    $arrEmpleados = $fabrica->GetEmpleados();
    $empleados = "";
    
    if(count($arrEmpleados) == 0)
    {
        echo "<tr>
                <td style=text-align:left;padding-left:15px colspan=2>
                    No hay empleados para mostrar.
                </td>
              </tr>";
    }
    else
    {
        $empleados =    '<div class="container">
                            <div class="row">
                                <div class="col-md-9">
                                    <h2>Listado de empleados</h2>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <th class="info">DNI</th>
                                                <th class="info">Nombre</th>
                                                <th class="info">Apellido</th>
                                                <th class="info">Sexo</th>
                                                <th class="info">Legajo</th>
                                                <th class="info">Sueldo</th>
                                                <th class="info">Turno</th>
                                                <th class="info">Path Foto</th>
                                                <th class="info">Foto</th>
                                                <th class="info"></th>
                                            </thead>';
        foreach($fabrica->GetEmpleados() as $item)
        {
            $empleados .= "<tr>
                                <td>{$item->GetDni()}</td>
                                <td>{$item->GetNombre()}</td>
                                <td>{$item->GetApellido()}</td>
                                <td>{$item->GetSexo()}</td>
                                <td>{$item->GetLegajo()}</td>
                                <td>{$item->GetSueldo()}</td>
                                <td>{$item->GetTurno()}</td>
                                <td>{$item->GetPathFoto()}</td>
                                <td><img src='archivos/".$item->GetPathFoto()."' width='90px' height='90px'/></td>
                                <td>
                                    <input type=button value=Modificar id=btnModificar onclick=Main.ModificarEmpleado({$item->GetDni()})>
                                    <br>
                                    <br>
                                    <input type=button value=Eliminar id=btnEliminar onclick=Main.EliminarEmpleado({$item->GetLegajo()})
                                </td>
                          </tr>";
        }
        $empleados .= "</table>";
    
        echo $empleados;
    }
?>


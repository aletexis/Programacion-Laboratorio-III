<?php
    require_once("./backendBD/empleado_bd.php");
    require_once("./backendBD/validarSesion_bd.php");
    require_once('./backendBD/fabrica_bd.php');
    
    $apellido = "";
    $nombre = "";
    $sexo = "";
    $legajo = "";
    $sueldo = "";
    $turno = "";
    $foto = "";
    $readonly = "";
    $masculino = '';
    $femenino = '';
    $turnoM = 'checked';
    $turnoT = '';
    $turnoN = '';
    $modificar = '';
    $boton = "Enviar";

    $dni = isset($_POST["dni"]) ? $_POST["dni"] : NULL;
    
    if($dni != NULL)
    {
        $fabrica = new Fabrica(" ",7);
        $fabrica->TraerDeBaseDeDatos();
        $empleadoaModificar = NULL;
    
        foreach($fabrica->GetEmpleados() as $item)
        {
            if($item->GetDni() == $dni)
            {
                $empleadoaModificar = $item;
                $apellido = $empleadoaModificar->GetApellido();
                $nombre = $empleadoaModificar->GetNombre();
                $sexo = $empleadoaModificar->GetSexo();
                $legajo = $empleadoaModificar->GetLegajo();
                $sueldo = $empleadoaModificar->GetSueldo();
                $turno = $empleadoaModificar->GetTurno();
                $readonly = "readonly";
                break;
            }
        }

        $modificar = "ok";
        $boton = "Modificar";

        if($sexo == "M")
        {
            $masculino = "selected";
        }
        else
        {
            $femenino = "selected";
        }

        if($turno == "M")
        {
            $turnoM = "checked";
        }
        else if($turnoT == "T")
        {
            $turnoT = "checked";
            $turnoM = '';
        }
        else
        {
            $turnoN = "checked";
            $turnoM = '';
        }
    }

    if($dni != NULL)
    {
        echo "<h2>Modificar Empleado</h2>";
    }
    else
    {
        echo "<h2>Alta de Empleado</h2>";
    }

    echo "<table align=center>
                <tr>
                    <th style=text-align:left;padding-left:15px colspan=2>
                        <h4>Datos personales</h4>
                    </th>
                    <tr>
                        <td style=text-align:left;padding-left:15px colspan=2><hr></td>
                    </tr>
                </tr>
                <tr>
                    <td style=text-align:left;padding-left:15px >DNI: </td>
                    <td style=text-align:left;padding-left:15px>
                        <input type=number name=txtDni id=txtDni min=1000000 
                        value=$dni $readonly>
                        <span id=spanTxtDni style= display:none;color:red>*</span>
                    </td>
                </tr>
                <tr>
                    <td style=text-align:left;padding-left:15px>Apellido: </td>
                    <td style=text-align:left;padding-left:15px>
                        <input type=text name=txtApellido id=txtApellido
                        value=$apellido>
                        <span id=spanTxtApellido style= display:none;color:red>*</span>
                    </td>
                </tr>
                <tr>
                    <td style=text-align:left;padding-left:15px>Nombre: </td>
                    <td style=text-align:left;padding-left:15px>
                        <input type=text name=txtNombre id=txtNombre
                        value=$nombre>
                        <span id=spanTxtNombre style= display:none;color:red>*</span>
                    </td>
                </tr>
                <tr>
                    <td style=text-align:left;padding-left:15px>Sexo: </td>
                    <td style=text-align:left;padding-left:15px>
                        <select name=cboSexo id=cboSexo>
                            <option value=--->Seleccione</option>
                            <option value=F $femenino>Femenino</option>
                            <option value=M $masculino>Masculino</option>
                        </select>
                        <span id=spanCboSexo style= display:none;color:red>*</span>
                    </td>
                </tr>
                <tr>
                    <th style=text-align:left;padding-left:15px colspan=2>
                        <h4>Datos laborales</h4>
                    </th>
                </tr>
                <tr>
                    <td style=text-align:left;padding-left:15px colspan=2>
                        <hr>
                    </td>
                </tr>
                <tr>
                    <td style=text-align:left;padding-left:15px>Legajo: </td>
                    <td style=text-align:left;padding-left:15px>
                        <input type=number name=txtLegajo id=txtLegajo min=100
                        value = $legajo $readonly>
                        <span id=spanTxtLegajo style= display:none;color:red>*</span>
                    </td>
                </tr>
                <tr>
                    <td style=text-align:left;padding-left:15px>Sueldo: </td>
                    <td style=text-align:left;padding-left:15px>
                        <input type=number step=500 name=txtSueldo id=txtSueldo
                        value= $sueldo>
                        <span id=spanTxtSueldo style= display:none;color:red>*</span>
                    </td>
                </tr>
                <tr>
                    <td style=text-align:left;padding-left:15px>Turno: </td>
                </tr>
                <tr>
                    <td style=text-align:left;padding-left:60px>
                        <input type=radio name=rdoTurno value=0 $turnoM>
                    </td>
                    <td>Mañana</td>
                </tr>
                <tr>
                    <td style=text-align:left;padding-left:60px>
                        <input type=radio name=rdoTurno value=1 $turnoT>
                    </td>
                    <td>Tarde</td>
                </tr>
                <tr>
                    <td style=text-align:left;padding-left:60px>
                        <input type=radio name=rdoTurno value=2 $turnoN>
                    </td>
                    <td>Noche</td>
                </tr>
                <tr>
                    <td style=text-align:left;padding-left:15px>Foto:</td>
                    <td style=text-align:left;padding-left:15px>
                        <input type=file name=file id=file>
                        <span id=spanFile style= display:none;color:red>*</span>
                        <input type=hidden name=hdnModificar id=hdnModificar value=$modificar>
                    </td>
                </tr>
                <tr>
                    <td style=text-align:left;padding-left:15px colspan=2>
                        <hr>
                    </td>
                </tr>
                <tr>
                    <td colspan=2 align=right>
                    <input type=button value=Limpiar onclick='Main.MostrarForm()'>
                    </td>
                </tr>
                <tr>
                    <td colspan=2 align=right>
                        <input type=submit onclick=AdministrarValidacionesBD() name=btnEnviar id=btnEnviar value=$boton>
                    </td>
                </tr>
        </table>";

?>
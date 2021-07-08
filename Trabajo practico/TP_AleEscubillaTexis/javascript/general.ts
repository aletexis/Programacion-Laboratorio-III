const AdministrarValidaciones = () =>{
    let sueldoMaximo: number = ObtenerSueldoMaximo(ObtenerTurnoSeleccionado());
    let dni: number = parseInt((<HTMLInputElement> document.getElementById("txtDni")).value);
    let sueldo: number = parseInt((<HTMLInputElement> document.getElementById("txtSueldo")).value);
    let legajo: number = parseInt((<HTMLInputElement> document.getElementById("txtLegajo")).value);
    
    if(!ValidarCamposVacios("txtApellido"))
    {
        AdministrarSpanError("spanTxtApellido", true);
    }
    else
    {
        AdministrarSpanError("spanTxtDni", false);
    }


    if(!ValidarCamposVacios("txtNombre"))
    {
        AdministrarSpanError("spanTxtNombre", true);
    }
    else
    {
        AdministrarSpanError("spanTxtNombre", false);
    }

    
    if(!ValidarCombo("cboSexo","---"))
    {
        AdministrarSpanError("spanCboSexo", true);
    }
    else
    {
        AdministrarSpanError("spanCboSexo", false);
    }

    if(!ValidarRangoNumerico(dni,1000000,55000000))
    {
        AdministrarSpanError("spanTxtDni", true);
    }
    else
    {
        AdministrarSpanError("spanTxtDni", false);
    }

    if(!ValidarRangoNumerico(legajo,100,550))
    {
        AdministrarSpanError("spanTxtLegajo", true);
    }
    else
    {
        AdministrarSpanError("spanTxtLegajo", false);
    }

    if(!ValidarRangoNumerico(sueldo,8000,sueldoMaximo))
    {
        AdministrarSpanError("spanTxtSueldo", true);
        
    }
    else
    {
        AdministrarSpanError("spanTxtSueldo", false);
    }

    if(!ValidarCamposVacios("file"))
    {
        AdministrarSpanError("spanFile", true);
    }
    else
    {
        AdministrarSpanError("spanFile", false);
    }

    if(ValidarCamposVacios("txtNombre") &&
    ValidarCamposVacios("txtApellido") &&
    ValidarCamposVacios("file") &&
    ValidarCombo("cboSexo","---") &&
    ValidarRangoNumerico(dni,1000000,55000000) &&
    ValidarRangoNumerico(legajo,100,550) &&
    ValidarRangoNumerico(sueldo,8000,sueldoMaximo))
    {
        Main.CargarDatos();
    }
}

const AdministrarValidacionesLogin: Function = (e: Event) =>
{
    let dni: number = parseInt((<HTMLInputElement> document.getElementById("txtDni")).value);
    
    if(!ValidarRangoNumerico(dni,1000000,55000000))
    {
        AdministrarSpanError("spanTxtDni", true);
    }
    else
    {
        AdministrarSpanError("spanTxtDni", false);
    }
    
    if(!ValidarCamposVacios("txtApellido"))
    {
        AdministrarSpanError("spanTxtApellido", true);
    }
    else
    {
        AdministrarSpanError("spanTxtApellido", false);
    }

    if(!VerificarValidacionesLogin())
    {
        e.preventDefault();
    }
}
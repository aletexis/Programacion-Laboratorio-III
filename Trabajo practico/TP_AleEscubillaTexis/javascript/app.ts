/// <reference path="ajax.ts" />

window.onload = (): void =>
{
    Main.RefrescarPagina();
}

namespace Main
{
    export const RefrescarPagina = (): void =>
    {
        MostrarEmpleados();
        MostrarForm();
    }

    export const MostrarEmpleados = (): void =>
    {
        let ajax = new Ajax();
        ajax.Post("./backend/mostrar.php",
        MostrarEmpleadosSuccess);    
    }

    export function MostrarForm(): void{
        let ajax = new Ajax();
        ajax.Post("./indexArchivo.php",
        MostrarFormSuccess);  
    }

    export const EliminarEmpleado = (legajo: string): void =>
    {
        let ajax = new Ajax();
        let parametros: string = `legajo=${legajo}`

        ajax.Get("./backend/eliminar.php",
        DeleteSuccess,
        parametros,
        Fail);
    }

    export function MostrarEmpleadosSuccess(empleados:string):void {
        console.log(empleados);
        (<HTMLDivElement>document.getElementById("divEmpleados")).innerHTML = empleados;
    }

    export function MostrarFormSuccess(respuesta: string): void{
        console.log(respuesta);
        (<HTMLDivElement>document.getElementById("divFrm")).innerHTML = respuesta;
    }

    export function DeleteSuccess(retorno: string):void {
        console.log(retorno);
        MostrarEmpleados();
    }

    export function Fail(retorno:string):void {
        console.log(retorno);
        alert("Ha ocurrido un ERROR!!!");
    }

    export function ModificarEmpleado(dni: number): void
    {
        let ajax = new Ajax();
        let parametros: string = `dni=${dni}`;

        ajax.Post("./indexArchivo.php",
        MostrarFormSuccess,
        parametros,
        Fail
        );
    }

    export function CargarDatos(): void
    {
        let ajax = new Ajax();
        let dni: string = (<HTMLInputElement> document.getElementById("txtDni")).value;
        let nombre: string = (<HTMLInputElement> document.getElementById("txtNombre")).value;
        let apellido: string = (<HTMLInputElement> document.getElementById("txtApellido")).value;
        let sueldo: string = (<HTMLInputElement> document.getElementById("txtSueldo")).value;
        let legajo: string = (<HTMLInputElement> document.getElementById("txtLegajo")).value;
        let turno: string = ObtenerTurnoSeleccionado();
        let sexo: string = (<HTMLInputElement> document.getElementById("cboSexo")).value;
        let archivo: FileList | null = (<HTMLInputElement>document.getElementById("file")).files;
        let modificar = (<HTMLInputElement>document.getElementById("hdnModificar")).value;

        let form: FormData = new FormData();

        form.append('file', archivo[0]);
        form.append("txtNombre",nombre);
        form.append("txtDni",dni);
        form.append("txtApellido",apellido);
        form.append("txtSueldo",sueldo);
        form.append("txtLegajo",legajo);
        form.append("rdoTurno",turno);
        form.append("cboSexo",sexo);
        form.append("hdnModificar",modificar);

        MandarEmpleado(form);
    }

    const MandarEmpleado = (form: FormData) =>
    {
        let ajax = new Ajax();

        ajax.Post("./backend/administracion.php",
        RefrescarPagina,
        form,
        Fail);
    }
}
/// <reference path="ajax.ts" />

window.onload = (): void =>
{
    MainBD.RefrescarPagina();
}

namespace MainBD
{
    export const RefrescarPagina = (): void =>
    {
        console.clear();
        MostrarFormBD();
        MostrarEmpleadosBD();
    }
    
    export const MostrarEmpleadosBD = (): void =>
        {
            let ajax = new Ajax();
            ajax.Post("./backendBD/mostrar_bd.php",
            MostrarEmpleadosSuccess);    
        }
    
    export function MostrarFormBD(): void{
        let ajax = new Ajax();
        ajax.Post("./index_bd.php",
        MostrarFormSuccess);  
    }

    export const EliminarEmpleadoBD = (legajo: string): void =>
    {
        let ajax = new Ajax();
        let parametros: string = `legajo=${legajo}`

        ajax.Get("./backendBD/eliminar_bd.php",
        DeleteSuccessBD,
        parametros,
        Fail);
    }

    export function MostrarEmpleadosSuccess(empleados:string):void {
        console.clear();
        console.log(empleados);
        (<HTMLDivElement>document.getElementById("divEmpleados")).innerHTML = empleados;
    }

    export function MostrarFormSuccess(respuesta: string): void{
        console.log(respuesta);
        (<HTMLDivElement>document.getElementById("divFrm")).innerHTML = respuesta;
    }

    export function DeleteSuccessBD(retorno: string):void {
        console.clear();
        console.log(retorno);
        MostrarEmpleadosBD();
    }

    export function Fail(retorno:string):void {
        console.clear();
        console.log(retorno);
        alert("Ha ocurrido un ERROR!!!");
    }

    export function ModificarEmpleadoBD(dni: number): void
    {
        let ajax = new Ajax();
        let parametros: string = `dni=${dni}`;

        ajax.Post("./index_bd.php",
        MostrarFormSuccess,
        parametros,
        Fail
        );
    }


    export function CargarDatosBD(): void
    {
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

        MandarEmpleadoBD(form);
    }

    const MandarEmpleadoBD = (form: FormData) =>
    {
        let ajax = new Ajax();

        ajax.Post("./backendBD/administracion_bd.php",
        RefrescarPagina,
        form,
        Fail);
    }
}
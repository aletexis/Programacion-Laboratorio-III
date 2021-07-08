"use strict";
/// <reference path="ajax.ts" />
window.onload = function () {
    MainBD.RefrescarPagina();
};
var MainBD;
(function (MainBD) {
    MainBD.RefrescarPagina = function () {
        console.clear();
        //console.log(respuesta);
        MostrarFormBD();
        MainBD.MostrarEmpleadosBD();
    };
    MainBD.MostrarEmpleadosBD = function () {
        var ajax = new Ajax();
        ajax.Post("./backendBD/mostrar_bd.php", MostrarEmpleadosSuccess);
    };
    function MostrarFormBD() {
        var ajax = new Ajax();
        ajax.Post("./backendBD/index_bd.php", MostrarFormSuccess);
    }
    MainBD.MostrarFormBD = MostrarFormBD;
    MainBD.EliminarEmpleadoBD = function (legajo) {
        var ajax = new Ajax();
        var parametros = "legajo=" + legajo;
        ajax.Get("./backendBD/eliminar_bd.php", DeleteSuccessBD, parametros, Fail);
    };
    function MostrarEmpleadosSuccess(empleados) {
        console.clear();
        console.log(empleados);
        document.getElementById("divEmpleados").innerHTML = empleados;
    }
    MainBD.MostrarEmpleadosSuccess = MostrarEmpleadosSuccess;
    function MostrarFormSuccess(respuesta) {
        console.log(respuesta);
        document.getElementById("divFrm").innerHTML = respuesta;
    }
    MainBD.MostrarFormSuccess = MostrarFormSuccess;
    function DeleteSuccessBD(retorno) {
        console.clear();
        console.log(retorno);
        MainBD.MostrarEmpleadosBD();
    }
    MainBD.DeleteSuccessBD = DeleteSuccessBD;
    function Fail(retorno) {
        console.clear();
        console.log(retorno);
        alert("Ha ocurrido un ERROR!!!");
    }
    MainBD.Fail = Fail;
    function ModificarEmpleadoBD(dni) {
        var ajax = new Ajax();
        var parametros = "dni=" + dni;
        ajax.Post("./backendBD/index_bd.php", MostrarFormSuccess, parametros, Fail);
    }
    MainBD.ModificarEmpleadoBD = ModificarEmpleadoBD;
    function CargarDatosBD() {
        var ajax = new Ajax();
        var dni = document.getElementById("txtDni").value;
        var nombre = document.getElementById("txtNombre").value;
        var apellido = document.getElementById("txtApellido").value;
        var sueldo = document.getElementById("txtSueldo").value;
        var legajo = document.getElementById("txtLegajo").value;
        var turno = ObtenerTurnoSeleccionado();
        var sexo = document.getElementById("cboSexo").value;
        var archivo = document.getElementById("file").files;
        var modificar = document.getElementById("hdnModificar").value;
        var form = new FormData();
        form.append('file', archivo[0]);
        form.append("txtNombre", nombre);
        form.append("txtDni", dni);
        form.append("txtApellido", apellido);
        form.append("txtSueldo", sueldo);
        form.append("txtLegajo", legajo);
        form.append("rdoTurno", turno);
        form.append("cboSexo", sexo);
        form.append("hdnModificar", modificar);
        MandarEmpleadoBD(form);
    }
    MainBD.CargarDatosBD = CargarDatosBD;
    var MandarEmpleadoBD = function (form) {
        var ajax = new Ajax();
        ajax.Post("./backendBD/administracion_bd.php", MainBD.RefrescarPagina, form, Fail);
    };
})(MainBD || (MainBD = {}));
//# sourceMappingURL=appBD.js.map
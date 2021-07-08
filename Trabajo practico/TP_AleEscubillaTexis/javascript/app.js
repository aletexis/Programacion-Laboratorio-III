"use strict";
/// <reference path="ajax.ts" />
window.onload = function () {
    Main.RefrescarPagina();
};
var Main;
(function (Main) {
    Main.RefrescarPagina = function () {
        console.clear();
        //console.log(respuesta);
        MostrarForm();
        Main.MostrarEmpleados();
    };
    Main.MostrarEmpleados = function () {
        var ajax = new Ajax();
        ajax.Post("./backend/mostrar.php", MostrarEmpleadosSuccess);
    };
    function MostrarForm() {
        var ajax = new Ajax();
        ajax.Post("./indexArchivo.php", MostrarFormSuccess);
    }
    Main.MostrarForm = MostrarForm;
    Main.EliminarEmpleado = function (legajo) {
        var ajax = new Ajax();
        var parametros = "legajo=" + legajo;
        ajax.Get("./backend/eliminar.php", DeleteSuccess, parametros, Fail);
    };
    function MostrarEmpleadosSuccess(empleados) {
        console.clear();
        console.log(empleados);
        document.getElementById("divEmpleados").innerHTML = empleados;
    }
    Main.MostrarEmpleadosSuccess = MostrarEmpleadosSuccess;
    function MostrarFormSuccess(respuesta) {
        console.log(respuesta);
        document.getElementById("divFrm").innerHTML = respuesta;
    }
    Main.MostrarFormSuccess = MostrarFormSuccess;
    function DeleteSuccess(retorno) {
        console.clear();
        console.log(retorno);
        Main.MostrarEmpleados();
    }
    Main.DeleteSuccess = DeleteSuccess;
    function Fail(retorno) {
        console.clear();
        console.log(retorno);
        alert("Ha ocurrido un ERROR!!!");
    }
    Main.Fail = Fail;
    function ModificarEmpleado(dni) {
        var ajax = new Ajax();
        var parametros = "dni=" + dni;
        ajax.Post("./indexArchivo.php", MostrarFormSuccess, parametros, Fail);
    }
    Main.ModificarEmpleado = ModificarEmpleado;
    function CargarDatos() {
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
        MandarEmpleado(form);
    }
    Main.CargarDatos = CargarDatos;
    var MandarEmpleado = function (form) {
        var ajax = new Ajax();
        ajax.Post("./backend/administracion", Main.RefrescarPagina, form, Fail);
    };
})(Main || (Main = {}));
//# sourceMappingURL=app.js.map
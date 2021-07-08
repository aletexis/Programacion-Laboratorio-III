var Ajax = /** @class */ (function () {
    function Ajax() {
        var _this = this;
        this.Get = function (ruta, success, params, error) {
            if (params === void 0) { params = ""; }
            var parametros = params.length > 0 ? params : "";
            ruta = params.length > 0 ? ruta + "?" + parametros : ruta;
            _this.xhr.open('GET', ruta);
            _this.xhr.send();
            _this.xhr.onreadystatechange = function () {
                if (_this.xhr.readyState === Ajax.DONE) {
                    if (_this.xhr.status === Ajax.OK) {
                        success(_this.xhr.responseText);
                    }
                    else {
                        if (error !== undefined) {
                            error(_this.xhr.status);
                        }
                    }
                }
            };
        };
        this.Post = function (ruta, success, params, error) {
            if (params === void 0) { params = ""; }
            _this.xhr.open('POST', ruta, true);
            if (typeof (params) == "string") {
                _this.xhr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
            }
            else {
                _this.xhr.setRequestHeader("enctype", "multipart/form-data");
            }
            _this.xhr.send(params);
            _this.xhr.onreadystatechange = function () {
                if (_this.xhr.readyState === Ajax.DONE) {
                    if (_this.xhr.status === Ajax.OK) {
                        success(_this.xhr.responseText);
                    }
                    else {
                        if (error !== undefined) {
                            error(_this.xhr.status);
                        }
                    }
                }
            };
        };
        this.xhr = new XMLHttpRequest();
        Ajax.DONE = 4;
        Ajax.OK = 200;
    }
    return Ajax;
}());
var ValidarCamposVacios = function (id) {
    var valor = document.getElementById(id).value;
    valor = valor.replace(/ /g, "");
    if (valor === "" || valor == null || valor == undefined) {
        return false;
    }
    return true;
};
var ValidarRangoNumerico = function (numero, min, max) {
    if (numero >= min && numero <= max) {
        return true;
    }
    return false;
};
var ValidarCombo = function (id, incorrecto) {
    var valor = document.getElementById(id).value;
    if (valor !== incorrecto) {
        return true;
    }
    return false;
};
var ObtenerTurnoSeleccionado = function () {
    var elemento = (document.querySelectorAll('input[name="rdoTurno"]'));
    var flag = 0;
    if (elemento != null) {
        for (var i = 0; i < elemento.length; i++) {
            if (elemento[i].checked) {
                return elemento[i].value;
            }
        }
    }
    return "0";
};
var ObtenerSueldoMaximo = function (turno) {
    switch (turno) {
        case "0":
            return 20000;
        case "1":
            return 18500;
        default:
            return 25000;
    }
};
var AdministrarSpanError = function (id, bool) {
    var span = document.getElementById(id);
    if (bool) {
        span.style.display = "block";
    }
    else {
        span.style.display = "none";
    }
};
var VerificarValidacionesLogin = function () {
    var spanDni = document.getElementById("spanTxtDni").style.display;
    var spanApellido = document.getElementById("spanTxtApellido").style.display;
    if (spanDni === "none" && spanApellido === "none") {
        return true;
    }
    return false;
};
var AdministrarModificar = function (dni) {
    var input = document.getElementById("hiddenInput");
    var myForm = document.getElementById('formMostrar');
    input.value = dni;
    myForm.submit();
};
var AdministrarValidacionesBD = function () {
    var sueldoMaximo = ObtenerSueldoMaximo(ObtenerTurnoSeleccionado());
    var dni = parseInt(document.getElementById("txtDni").value);
    var sueldo = parseInt(document.getElementById("txtSueldo").value);
    var legajo = parseInt(document.getElementById("txtLegajo").value);
    if (!ValidarCamposVacios("txtApellido")) {
        AdministrarSpanError("spanTxtApellido", true);
    }
    else {
        AdministrarSpanError("spanTxtDni", false);
    }
    if (!ValidarCamposVacios("txtNombre")) {
        AdministrarSpanError("spanTxtNombre", true);
    }
    else {
        AdministrarSpanError("spanTxtNombre", false);
    }
    if (!ValidarCombo("cboSexo", "---")) {
        AdministrarSpanError("spanCboSexo", true);
    }
    else {
        AdministrarSpanError("spanCboSexo", false);
    }
    if (!ValidarRangoNumerico(dni, 1000000, 55000000)) {
        AdministrarSpanError("spanTxtDni", true);
    }
    else {
        AdministrarSpanError("spanTxtDni", false);
    }
    if (!ValidarRangoNumerico(legajo, 100, 550)) {
        AdministrarSpanError("spanTxtLegajo", true);
    }
    else {
        AdministrarSpanError("spanTxtLegajo", false);
    }
    if (!ValidarRangoNumerico(sueldo, 8000, sueldoMaximo)) {
        AdministrarSpanError("spanTxtSueldo", true);
    }
    else {
        AdministrarSpanError("spanTxtSueldo", false);
    }
    if (!ValidarCamposVacios("file")) {
        AdministrarSpanError("spanFile", true);
    }
    else {
        AdministrarSpanError("spanFile", false);
    }
    if (ValidarCamposVacios("txtNombre") &&
        ValidarCamposVacios("txtApellido") &&
        ValidarCamposVacios("file") &&
        ValidarCombo("cboSexo", "---") &&
        ValidarRangoNumerico(dni, 1000000, 55000000) &&
        ValidarRangoNumerico(legajo, 100, 550) &&
        ValidarRangoNumerico(sueldo, 8000, sueldoMaximo)) {
        MainBD.CargarDatosBD();
    }
};
/// <reference path="ajax.ts" />
window.onload = function () {
    MainBD.RefrescarPagina();
};
var MainBD;
(function (MainBD) {
    MainBD.RefrescarPagina = function () {
        console.clear();
        MostrarFormBD();
        MainBD.MostrarEmpleadosBD();
    };
    MainBD.MostrarEmpleadosBD = function () {
        var ajax = new Ajax();
        ajax.Post("./backendBD/mostrar_bd.php", MostrarEmpleadosSuccess);
    };
    function MostrarFormBD() {
        var ajax = new Ajax();
        ajax.Post("./index_bd.php", MostrarFormSuccess);
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
        ajax.Post("./index_bd.php", MostrarFormSuccess, parametros, Fail);
    }
    MainBD.ModificarEmpleadoBD = ModificarEmpleadoBD;
    function CargarDatosBD() {
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

"use strict";
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
//# sourceMappingURL=validaciones.js.map
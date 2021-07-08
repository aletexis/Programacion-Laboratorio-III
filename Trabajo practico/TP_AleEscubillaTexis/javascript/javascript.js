var ValidarCamposVacios = function (id) {
    var valor = document.getElementById(id).value;
    valor = valor.replace(/ /g, "");
    if (valor === "" || valor == undefined) {
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
                flag = parseInt(elemento[i].value);
                break;
            }
        }
    }
    if (flag === 1) {
        return "Tarde";
    }
    else if (flag === 2) {
        return "Noche";
    }
    return "Mañana";
};
var ObtenerSueldoMaximo = function (turno) {
    switch (turno) {
        case "Mañana":
            return 20000;
        case "Tarde":
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
var AdministrarValidaciones = function (e) {
    var sueldoMaximo = ObtenerSueldoMaximo(ObtenerTurnoSeleccionado());
    var dni = parseInt(document.getElementById("txtDni").value);
    var sueldo = parseInt(document.getElementById("txtSueldo").value);
    var legajo = parseInt(document.getElementById("txtLegajo").value);
    if (!ValidarCamposVacios("txtApellido")
        || !ValidarCamposVacios("txtNombre")) {
        alert("Hay campo/s vacio/s");
        e.preventDefault();
        return;
    }
    if (!ValidarCombo("cboSexo", "---")) {
        alert("Debe seleccionar el campo sexo");
        e.preventDefault();
        return;
    }
    if (!ValidarRangoNumerico(dni, 1000000, 55000000)) {
        alert("El Dni debe ser mayor igual a 1 Millon y menor igual a 55 millones");
        e.preventDefault();
        return;
    }
    if (!ValidarRangoNumerico(legajo, 100, 550)) {
        alert("El legajo debe ser mayor igual a 100 y menor igual a 550");
        e.preventDefault();
        return;
    }
    if (!ValidarRangoNumerico(sueldo, 8000, sueldoMaximo)) {
        alert("El sueldo debe ser mayor igual a 8000 y menor igual a " + sueldoMaximo);
        e.preventDefault();
        return;
    }
};
var VerificarValidacionesLogin = function (e) {
    if (!ValidarRangoNumerico("txtDni", 1000000, 55000000)) {
        AdministrarSpanError("spanTxtDni", true);
        e.preventDefault();
        return false;
    }
    return true;
};

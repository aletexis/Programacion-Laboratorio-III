"use strict";
var AdministrarValidacionesBD = function (e) {
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
    e.preventDefault();
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
//# sourceMappingURL=generalBD.js.map
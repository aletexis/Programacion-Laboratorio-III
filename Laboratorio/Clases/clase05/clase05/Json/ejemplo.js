"use strict";
/// <reference path="../ajax.ts" />
function ObtenerEquiposPorIdPais(idPais) {
    if (idPais == 0) {
        return;
    }
    var pagina = "../BACKEND/paises_equipos.php";
    var params = "idPais=" + idPais.toString();
    var ajax = new Ajax();
    document.getElementById("cboEquipo").innerHTML = "";
    ajax.Post(pagina, function (resultado) {
        var equiposArray = JSON.parse(resultado);
        for (var i = 0; i < equiposArray.length; i++) {
            var elemento = {};
            elemento.value = equiposArray[i].id;
            elemento.innerHTML = equiposArray[i].nombre;
            var opcion = "<option value='" + elemento.value + "'>" + elemento.innerHTML + "</option>";
            document.getElementById("cboEquipo").innerHTML += opcion;
        }
    }, params, Fail);
}
function Fail(retorno) {
    console.clear();
    console.log("ERROR!!!");
    console.log(retorno);
}
//# sourceMappingURL=ejemplo.js.map
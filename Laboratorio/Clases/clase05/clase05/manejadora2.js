"use strict";
/// <reference path="./ajax.ts" />
var Test;
(function (Test) {
    function EnviarJSON() {
        //CREO UN OBJETO JSON
        var persona = { "nombre": "Juan", "edad": 35 };
        var pagina = "../BACKEND/json_test_enviar.php";
        var ajax = new Ajax();
        var params = "miPersona=" + JSON.stringify(persona);
        ajax.Post(pagina, function (resultado) {
            document.getElementById("divResultado").innerHTML = resultado;
            console.clear();
            console.log(resultado);
        }, params, Fail);
    }
    Test.EnviarJSON = EnviarJSON;
    function RecibirJSON() {
        var pagina = "../BACKEND/json_test_recibir.php";
        var ajax = new Ajax();
        ajax.Post(pagina, function (resultado) {
            document.getElementById("divResultado").innerHTML = "";
            console.clear();
            console.log(resultado);
            var objJson = JSON.parse(resultado);
            console.log(objJson.nombre);
        }, "", Fail);
    }
    Test.RecibirJSON = RecibirJSON;
    function Fail(retorno) {
        console.clear();
        console.log("ERROR!!!");
        console.log(retorno);
    }
})(Test || (Test = {}));
//# sourceMappingURL=manejadora2.js.map
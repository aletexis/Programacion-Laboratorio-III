"use strict";
/// <reference path="./02_auto.ts" />
var vehiculos = [new Test.Auto("ROJO", 125000, "FERRARI"),
    new Test.Auto("AMARILLO", 200000, "SEAT")];
vehiculos.forEach(Mostrar);
function Mostrar(v) {
    console.log(v.Mostrar());
}
//Para poder debugguear, hay que generar un outFile de la jerarquia de clases en js
//# sourceMappingURL=03_main.js.map
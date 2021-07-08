"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
var _02_herencia_1 = require("./02_herencia"); //IMPORTO AUTO
//FUNCION GENERICA
function Generica(param) {
    console.log("El tipo es: " + typeof (param));
    return param;
}
//PASO EL TIPO DE FORMA EXPLICITA
var retStrring = Generica("hola");
console.log(retStrring);
//EL TIPO SE INFIERE
retStrring = Generica("mundo");
console.log(retStrring);
console.log("---------------------------");
var autito = new _02_herencia_1.Auto("ROJO", 125000, "FERRARI");
//PASO EL TIPO DE FORMA EXPLICITA
var retAuto = Generica(autito);
console.log(retAuto.Mostrar());
//EL TIPO SE INFIERE
retAuto = Generica(new _02_herencia_1.Auto("AMARILLO", 200000, "SEAT"));
console.log(retAuto.Mostrar());
console.log("---------------------------");
//CLASE GENERICA
var ClaseGenerica = /** @class */ (function () {
    function ClaseGenerica(uno, dos) {
        this.paramUno = uno;
        this.paramDos = dos;
    }
    ClaseGenerica.prototype.Mostrar = function () {
        console.log(this.paramUno + " - " + this.paramDos);
    };
    return ClaseGenerica;
}());
//PASO EL TIPO DE FORMA EXPLICITA
var obj = new ClaseGenerica("cadena", 10);
//EL TIPO SE INFIERE
var obj2 = new ClaseGenerica(true, "otra cadena");
obj.Mostrar();
obj2.Mostrar();
console.log("---------------------------");
//# sourceMappingURL=05_generics.js.map
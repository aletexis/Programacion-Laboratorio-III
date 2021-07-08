"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
var _01_clases_1 = require("./01_clases"); //IMPORTO AUTO
var a1 = new _01_clases_1.Auto("ROJO", 120500);
console.log(a1.color);
console.log(a1.Precio);
//METODOS GETTERS Y SETTERS
a1.SetColor("AZUL");
console.log(a1.GetColor());
//ACCESORES GET Y SET
a1.Precio = 666;
console.log(a1.Precio);
_01_clases_1.Auto.MetodoEstatico();
console.log("fin...!!");
//# sourceMappingURL=06_main.js.map
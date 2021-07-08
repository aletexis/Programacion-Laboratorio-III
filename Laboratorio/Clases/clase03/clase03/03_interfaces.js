"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.Auto = void 0;
var Auto = /** @class */ (function () {
    function Auto(color, precio) {
        this.precio = precio;
        this.color = color;
        this.patente = "sin patente";
    }
    Object.defineProperty(Auto.prototype, "Precio", {
        get: function () {
            return this.precio;
        },
        enumerable: false,
        configurable: true
    });
    //DE LA INTERFACE
    Auto.prototype.GetColor = function () {
        return this.color;
    };
    //DE LA INTERFACE
    Auto.prototype.SetColor = function (color) {
        this.color = color;
    };
    return Auto;
}());
exports.Auto = Auto;
//NOTAS:
//1) LAS INTERFACES SE PUEDEN HEREDAR
//2) LAS INTERFACES PUEDEN CONTENER ATRIBUTOS Y METODOS
//# sourceMappingURL=03_interfaces.js.map
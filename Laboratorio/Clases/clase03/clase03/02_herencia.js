"use strict";
var __extends = (this && this.__extends) || (function () {
    var extendStatics = function (d, b) {
        extendStatics = Object.setPrototypeOf ||
            ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
            function (d, b) { for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p]; };
        return extendStatics(d, b);
    };
    return function (d, b) {
        extendStatics(d, b);
        function __() { this.constructor = d; }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
})();
Object.defineProperty(exports, "__esModule", { value: true });
exports.Auto = exports.Vehiculo = void 0;
var Vehiculo = /** @class */ (function () {
    function Vehiculo(marca) {
        this.marca = marca;
    }
    Vehiculo.prototype.Mostrar = function () {
        return this.marca;
    };
    return Vehiculo;
}());
exports.Vehiculo = Vehiculo;
var Auto = /** @class */ (function (_super) {
    __extends(Auto, _super);
    function Auto(color, precio, marca) {
        var _this = _super.call(this, marca) || this;
        _this.precio = precio;
        _this.color = color;
        return _this;
    }
    Object.defineProperty(Auto.prototype, "Precio", {
        get: function () {
            return this.precio;
        },
        set: function (value) {
            this.precio = value;
        },
        enumerable: false,
        configurable: true
    });
    //POLIMORFISMO
    Auto.prototype.Mostrar = function () {
        return _super.prototype.Mostrar.call(this) + this.precio + this.color;
    };
    return Auto;
}(Vehiculo));
exports.Auto = Auto;
//# sourceMappingURL=02_herencia.js.map
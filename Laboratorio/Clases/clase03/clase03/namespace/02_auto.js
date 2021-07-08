"use strict";
/// <reference path="./01_vehiculo.ts" />
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
var Test;
(function (Test) {
    var Auto = /** @class */ (function (_super) {
        __extends(Auto, _super);
        function Auto(color, precio, marca) {
            var _this = _super.call(this, marca) || this;
            _this.precio = precio;
            _this.color = color;
            return _this;
        }
        Auto.prototype.GetPrecio = function () {
            return this.precio;
        };
        Auto.prototype.Mostrar = function () {
            return _super.prototype.Mostrar.call(this) + this.precio + this.color;
        };
        Auto.prototype.Acelerar = function () {
            console.log("Acelerando...");
        };
        return Auto;
    }(Test.Vehiculo));
    Test.Auto = Auto;
})(Test || (Test = {}));
//# sourceMappingURL=02_auto.js.map
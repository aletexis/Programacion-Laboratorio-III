"use strict";
var Test;
(function (Test) {
    function EjemplosJSON(queEjemplo) {
        switch (queEjemplo) {
            case 1://objeto
                console.clear();
                //objeto simple
                var persona = { "nombre": "Juan", "edad": 35 };
                console.log(persona.nombre + " - " + persona.edad);
                console.log(persona["nombre"] + " - " + persona["edad"]);
                break;
            case 2://arrays
                console.clear();
                //array simple
                var nombres = ["Juan", "Pablo", "Ramiro"];
                for (var i = 0; i < nombres.length; i++)
                    console.log(nombres[i]);
                //array de objetos
                var personas = [
                    { "nombre": "Juan", "edad": 35 },
                    { "nombre": "Anibal", "edad": 26 }
                ];
                for (var i = 0; i < personas.length; i++)
                    console.log(personas[i].nombre + " - " + personas[i].edad);
                break;
            case 3://uso del JSON.parse
                console.clear();
                //cadena con un array de objetos
                var cadJSON = ' [{ "nombre" : "Juan", "edad" : 35 },{ "nombre" : "Anibal", "edad" : 26 }] ';
                var personasJSON = JSON.parse(cadJSON);
                for (var i = 0; i < personasJSON.length; i++)
                    console.log(personasJSON[i].nombre + " - " + personasJSON[i].edad);
                break;
            case 4://uso del JSON.stringify
                console.clear();
                //objeto simple
                var p = { "nombre": "Juan", "edad": 35 };
                var toString_1 = JSON.stringify(p);
                console.log(toString_1);
                var obj = JSON.parse(toString_1);
                console.log(obj.nombre + " - " + obj.edad);
                break;
            case 5://JSON con funciones
                console.clear();
                //objeto con funciones
                var personaFunc = {
                    "nombre": "Jorge",
                    "edad": 23,
                    "saludar": function () {
                        console.log("Hola soy " + this.nombre + " y tengo " + this.edad + ".");
                    }
                };
                personaFunc.saludar();
                break;
            case 6://JSON complejo con funciones
                console.clear();
                //array de objetos con funciones
                var personasFunc = {
                    "personas": [
                        { "nombre": "Juan", "edad": 35 },
                        { "nombre": "Anibal", "edad": 26 }
                    ],
                    "saludarTodos": function () {
                        for (var i = 0; i < this.personas.length; i++) {
                            console.log("Hola soy " + this.personas[i].nombre + " y tengo " + this.personas[i].edad + ".");
                        }
                    }
                };
                personasFunc.saludarTodos();
                break;
        }
    }
    Test.EjemplosJSON = EjemplosJSON;
    function IrHacia(pagina) {
        window.location.href = pagina;
    }
    Test.IrHacia = IrHacia;
})(Test || (Test = {}));
//# sourceMappingURL=manejadora.js.map
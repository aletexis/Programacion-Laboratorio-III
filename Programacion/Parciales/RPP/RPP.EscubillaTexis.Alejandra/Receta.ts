namespace Entidades 
{
    /*Receta, posee como atributos id(entero), nombre(cadena), ingredientes(cadena), tipo(cadena) y foto(cadena).
    Un constructor para inicializar los atributos.
    Un método ToJSON():JSON, que retornará la representación del objeto en formato JSON. */
    export class Receta
    {
        id : number;
        nombre : string;
        ingredientes : string;
        tipo : string;
        foto : string;
    
        constructor(id : number, nombre : string, ingredientes : string, tipo : string, foto : string)
        {
            this.id = id;
            this.nombre = nombre;
            this.ingredientes = ingredientes;
            this.tipo = tipo;
            this.foto = foto;
        }

        ToJSON() : JSON
        {
            let retornoJSON = `{"id":"${this.id}","nombre":"${this.nombre}","ingredientes":"${this.ingredientes}","tipo":"${this.tipo}","foto":"${this.foto}"}`;
            return JSON.parse(retornoJSON);
        }
    }
}
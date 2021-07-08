///<reference path="Persona.ts"/>
namespace Entidades
{
    /*Cocinero, hereda de Persona, posee como atributo especialidad(cadena). 
    Un constructor para inicializar los atributos.
    Un método ToJSON():JSON, que retornará la representación del objeto en formato JSON.
    Se debe de reutilizar el método ToString de la clase Persona. */
    
    export class Cocinero extends Persona
    {
        public especialidad : string;

        constructor(email : string, clave : string, especialidad : string)
        {
            super(email, clave);
            this.especialidad = especialidad;
        }

        ToJSON() : JSON
        {
            var cocinero = JSON.parse(super.ToString())
            cocinero["especialidad"] = this.especialidad;
            return cocinero;
        }
    }
}
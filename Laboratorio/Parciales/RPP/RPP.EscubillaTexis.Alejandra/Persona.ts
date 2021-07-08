/*Persona: email(cadena) y clave(cadena) como atributos. 
Un constructor que reciba dos parámetros.
Un método, ToString():string, que retorne la representación de la clase en formato cadena
(preparar la cadena para que, al juntarse con el método ToJSON, forme una cadena JSON válida). */

namespace Entidades
{
    export class Persona
    {
        public email : string;
        public clave : string;
        
        constructor(email : string, clave : string)
        {
            this.clave = clave;
            this.email = email;
        }

        ToString() : string
        {
            var person = JSON.stringify({email: this.email, clave: this.clave});
            return person.toString();
        }
    }
}
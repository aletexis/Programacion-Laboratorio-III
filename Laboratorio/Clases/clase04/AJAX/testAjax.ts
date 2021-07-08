
/// <reference path="ajax.ts" />

namespace Main{

    let ajax : Ajax = new Ajax();

    export function ClickGet():void {

        ajax.Get("http://localhost/lab_3/AJAX/BACKEND/backend.php", Success, "p=hola", Fail);

    }

    export function ClickPost():void {
    
        ajax.Post("http://localhost/lab_3/AJAX/BACKEND/backend.php", Success, "p=hola&p1=chau", Fail);
        //ajax.Post("http://localhost/lab_3/AJAX/BACKEND/fake.php", Success, "p=hola&p1=chau", Fail);
        
    }

    function Success(retorno:string):void {
        console.clear();
        console.log(retorno);
    }

    function Fail(retorno:string):void {
        console.clear();
        console.log(retorno);
    }

}
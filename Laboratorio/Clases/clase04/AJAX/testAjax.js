"use strict";
/// <reference path="ajax.ts" />
var Main;
(function (Main) {
    var ajax = new Ajax();
    function ClickGet() {
        ajax.Get("http://localhost/lab_3/AJAX/BACKEND/backend.php", Success, "p=hola", Fail);
    }
    Main.ClickGet = ClickGet;
    function ClickPost() {
        ajax.Post("http://localhost/lab_3/AJAX/BACKEND/backend.php", Success, "p=hola&p1=chau", Fail);
        //ajax.Post("http://localhost/lab_3/AJAX/BACKEND/fake.php", Success, "p=hola&p1=chau", Fail);
    }
    Main.ClickPost = ClickPost;
    function Success(retorno) {
        console.clear();
        console.log(retorno);
    }
    function Fail(retorno) {
        console.clear();
        console.log(retorno);
    }
})(Main || (Main = {}));
//# sourceMappingURL=testAjax.js.map
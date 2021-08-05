/// <reference path="../node_modules/@types/jquery/index.d.ts" />
var API = 'http://api_slim4/';
$(function () {
    $("#btnEnviar").on("click", function (event) {
        event.preventDefault();
        event.stopPropagation();
        var correo = $("#txtCorreo").val();
        var clave = $("#txtClave").val();
        var dato = {
            correo: correo,
            clave: clave
        };
        $.ajax({
            method: "POST",
            url: API + "login",
            dataType: "json",
            data: { user: JSON.stringify(dato) },
            async: true
        })
            .done(function (resultado) {
            if (resultado.exito) {
                localStorage.setItem("jwt", resultado.jwt);
                $(location).attr("href", API + "front-end/principal");
            }
            else {
                $(".alert").addClass("d-flex").removeClass("d-none");
                $(".alert p").html(resultado.mensaje);
            }
        })
            .fail(function (jqXHR, textStatus, errorThrown) {
            $(".alert").addClass("d-flex").removeClass("d-none");
            $(".alert p").html("Error, verifique los datos ingresados");
        });
    });
    $(".close").click(function () {
        $(".alert").addClass("d-none").removeClass("d-flex");
    });
    $("#btnRegistro").click(function () {
        $(location).attr("href", API + "front-end/registro");
    });
});
/// <reference path="../node_modules/@types/jquery/index.d.ts" />
$(function () {
    $("#btnEnviarRegistro").on("click", function (event) {
        event.preventDefault();
        event.stopPropagation();
        var token = localStorage.getItem("jwt");
        var foto = $("#foto").prop("files")[0];
        var correo = $("#txtCorreo").val();
        var clave = $("#txtClave").val();
        var nombre = $("#txtNombre").val();
        var apellido = $("#txtApellido").val();
        var perfil = $("#dpPerfil").val();
        var dato = {
            "correo": correo,
            "clave": clave,
            "nombre": nombre,
            "apellido": apellido,
            "perfil": perfil
        };
        var form = new FormData();
        var usuario = JSON.stringify(dato);
        form.append("usuario", usuario);
        form.append("foto", foto);
        $.ajax({
            method: "POST",
            url: API + "usuario",
            dataType: "json",
            data: form,
            headers: { token: token },
            async: true,
            contentType: false,
            processData: false
        })
            .done(function (resultado) {
            if (resultado.exito) {
                $(location).attr("href", API + "front-end/login");
            }
            else {
                $(".alert").addClass("d-flex").removeClass("d-none");
                $(".alert p").html(resultado.mensaje);
            }
        })
            .fail(function (jqXHR, textStatus, errorThrown) {
            $(".alert").addClass("d-flex").removeClass("d-none");
            $(".alert p").html("Error, verifique los datos ingresados");
        });
    });
    $(".close").click(function () {
        $(".alert").addClass("d-none").removeClass("d-flex");
    });
});
/// <reference path="../node_modules/@types/jquery/index.d.ts" />
$(function () {
    $("#usuarios").on("click", function () {
        $.ajax({
            method: "GET",
            url: API + "",
            dataType: "json",
            data: {},
            async: true
        })
            .done(function (resultado) {
            if (resultado.exito) {
                mostrarUsuarios(resultado.dato, "#derecha");
            }
        })
            .fail(function (jqXHR, textStatus, errorThrown) {
            $(".alert").addClass("d-flex").removeClass("d-none");
            $(".alert p").html(jqXHR.responseText);
        });
    });
    $("#perfiles").on("click", getPerfiles);
    $(".close").click(function () {
        $(".alert").addClass("d-none").removeClass('d-flex');
    });
});
function getPerfiles() {
    $.ajax({
        method: "GET",
        url: API + "perfil",
        dataType: "json",
        data: {},
        async: true
    })
        .done(function (resultado) {
        if (resultado.exito) {
            mostrarPerfiles(resultado.dato, "#izquierda");
        }
    })
        .fail(function (jqXHR, textStatus, errorThrown) {
        $(".alert").addClass("d-flex").removeClass("d-none");
        $(".alert p").html(jqXHR.responseText);
    });
}
function mostrarUsuarios(datos, lado) {
    var perfil = "";
    var tabla = "";
    tabla = "<table class='table table-striped'> \n    <thead>\n        <tr>\n            <td>CORREO</td>\n            <td>NOMBRE</td>\n            <td>APELLIDO</td>\n            <td>PERFIL</td>\n            <td>FOTO</td>\n        </tr>\n    </thead>\n    <tbody>\n    ";
    datos.forEach(function (usuario) {
        switch (usuario.id_perfil) {
            case "1":
                perfil = "propietario";
                break;
            case "2":
                perfil = "supervisor";
                break;
            case "3":
                perfil = "invitado";
                break;
            case "4":
                perfil = "empleado";
                break;
            case "5":
                perfil = "gerente";
                break;
            case "6":
                perfil = "no activo";
                break;
        }
        tabla += "<tr>\n          <td>" + usuario.correo + "</td>\n          <td>" + usuario.nombre + "</td>\n          <td>" + usuario.apellido + "</td>\n          <td>" + perfil + "</td>\n          <td><img src='../../src/fotos/" + usuario.foto + "' style='width: 50px; heigth: 50px'></td>\n      </tr>";
    });
    tabla += "</tbody></table>";
    $(lado).html(tabla);
}
function mostrarPerfiles(datos, lado) {
    var estado = "";
    var tabla = "";
    tabla = "<table class='table table-striped'> \n    <thead>\n        <tr>\n            <td>ID</td>\n            <td>DESCRIPCION</td>\n            <td>ESTADO</td>\n        </tr>\n    </thead>\n    <tbody>\n    ";
    datos.forEach(function (perfil) {
        switch (perfil.estado) {
            case "1":
                estado = "Activo";
                break;
            case "0":
                estado = "Inactivo";
                break;
        }
        var json = JSON.stringify(perfil);
        tabla += "<tr>\n              <td>" + perfil.id + "</td>\n              <td>" + perfil.descripcion + "</td>\n              <td>" + estado + "</td>\n      </tr>";
    });
    tabla += "</tbody></table>";
    $(lado).html(tabla);
}

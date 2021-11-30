/// <reference path="../node_modules/@types/jquery/index.d.ts" />


$(function () {
    $("#btnEnviarRegistro").on("click", function (event: Event) {
        event.preventDefault();
        event.stopPropagation();
        let token = localStorage.getItem("jwt");
        let foto = $("#foto").prop("files")[0];

        let correo = $("#txtCorreo").val();
        let clave = $("#txtClave").val();
        let nombre = $("#txtNombre").val();
        let apellido = $("#txtApellido").val();
        let perfil = $("#dpPerfil").val();

        let dato = {
            "correo":correo,
            "clave":clave,
            "nombre":nombre,
            "apellido":apellido,
            "perfil":perfil,
        }

        let form = new FormData();
        let usuario = JSON.stringify(dato);

        form.append("usuario",usuario);
        form.append("foto",foto);
  
        $.ajax({
          method: "POST",
          url: API + "public/usuarios",
          dataType: "json",
          data: form,
          headers: {token: token},
          async: true,
          contentType: false,
          processData: false
        })
        .done(function (resultado: any) {
          if (resultado.exito) {
            $(location).attr("href", API + "public/front-end-login");
          } else {
            $(".alert").addClass("d-flex").removeClass("d-none");
            $(".alert p").html(resultado.mensaje);
          }
        })
        .fail(function (jqXHR: any, textStatus: any, errorThrown: any) {
          $(".alert").addClass("d-flex").removeClass("d-none");
          $(".alert p").html("Error, verifique los datos ingresados");
        });
      });
  
      $(".close").click(function(){
          $(".alert").addClass("d-none").removeClass("d-flex");
      });
});
  
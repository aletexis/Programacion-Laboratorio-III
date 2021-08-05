/// <reference path="../node_modules/@types/jquery/index.d.ts" />

const API = 'http://api_slim4/';


$(function () {

  $("#btnEnviar").on("click", function (event: Event) {
    
    event.preventDefault();
    event.stopPropagation();

    let correo = $("#txtCorreo").val();
    let clave = $("#txtClave").val();
    let dato = {
      correo: correo,
      clave: clave,
    };

    $.ajax({
      method: "POST",
      url: API + "login",
      dataType: "json",
      data: { user: JSON.stringify(dato) },
      async: true,
    })
    .done(function (resultado: any) {
      if (resultado.exito)
      {
        localStorage.setItem("jwt", resultado.jwt);
        $(location).attr("href", API + "front-end/principal");
      }
      else
      {
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

  $("#btnRegistro").click(function(){
    $(location).attr("href", API + "front-end/registro");
  });
});


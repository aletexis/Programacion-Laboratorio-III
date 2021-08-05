/// <reference path="../node_modules/@types/jquery/index.d.ts" />

$(function () {
  
  $("#usuarios").on("click", function () {
    $.ajax({
      method: "GET",
      url: API + "",
      dataType: "json",
      data: {},
      async: true,
    })
      .done(function (resultado: any) {
        if (resultado.exito) {
          mostrarUsuarios(resultado.dato, "#derecha");
        }
      })
      .fail(function (jqXHR: any, textStatus: any, errorThrown: any) {   
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
    async: true,
  })
    .done(function (resultado: any) {
      if (resultado.exito) {
        mostrarPerfiles(resultado.dato,"#izquierda");
      }
    })
    .fail(function (jqXHR: any, textStatus: any, errorThrown: any) {
      $(".alert").addClass("d-flex").removeClass("d-none");
      $(".alert p").html(jqXHR.responseText);
    });
}

function mostrarUsuarios(datos: any, lado: string) {
  let perfil = "";
  let tabla = "";

    tabla = `<table class='table table-striped'> 
    <thead>
        <tr>
            <td>CORREO</td>
            <td>NOMBRE</td>
            <td>APELLIDO</td>
            <td>PERFIL</td>
            <td>FOTO</td>
        </tr>
    </thead>
    <tbody>
    `;

  datos.forEach((usuario: any) => {
    switch(usuario.id_perfil)
    {
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
    tabla += `<tr>
          <td>${usuario.correo}</td>
          <td>${usuario.nombre}</td>
          <td>${usuario.apellido}</td>
          <td>${perfil}</td>
          <td><img src='../../src/fotos/${usuario.foto}' style='width: 50px; heigth: 50px'></td>
      </tr>`;
  });

  tabla += "</tbody></table>";
  $(lado).html(tabla);
}

function mostrarPerfiles(datos: any, lado:string) {
  let estado = "";
  let tabla = "";

    tabla = `<table class='table table-striped'> 
    <thead>
        <tr>
            <td>ID</td>
            <td>DESCRIPCION</td>
            <td>ESTADO</td>
        </tr>
    </thead>
    <tbody>
    `;

  datos.forEach((perfil: any) => {
    switch(perfil.estado)
    {
      case "1":
        estado = "Activo";
        break;
      case "0":
        estado = "Inactivo";
        break;
    }
    let json = JSON.stringify(perfil);
    tabla += `<tr>
              <td>${perfil.id}</td>
              <td>${perfil.descripcion}</td>
              <td>${estado}</td>
      </tr>`;
  });

  tabla += "</tbody></table>";
  $(lado).html(tabla);
}

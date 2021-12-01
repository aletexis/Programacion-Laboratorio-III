/// <reference path="../node_modules/@types/jquery/index.d.ts" />

$(function () {
  
    // Mostrar
    $('#usuarios').on('click', MostrarUsuarios);
    $('#autos').on('click', MostrarAutos);
    
    // Logout
    $("#logout").on("click", Logout);
  
});

function Logout()
{   
    localStorage.removeItem("token");
    $(location).attr('href',API + "public/front-end-login");
}

function VerificarToken()
{
    let token:any = localStorage.getItem("token");
    $.ajax({
        type: 'GET',
        url: API + "public/login", 
        dataType: "json",
        data: {},
        headers : {"token":token},
        async: true

    })
    .done(function (resultado:any) {
        let usuario = resultado.datos;
        localStorage.setItem("usuario", JSON.stringify(usuario.data)); 
    })
    .fail(function (jqXHR:any, textStatus:any, errorThrown:any) {
        let retorno = JSON.parse(jqXHR.responseText);
        console.log(retorno);
        alert("La sesion ha expirado, sera redirigido al login");
        location.href = "front-end-login";
    });
}
    
function MostrarUsuarios()
{
    VerificarToken();
    $("#derecha").html("");
    $.ajax({
        type: "GET",
        url: API + "public/",
        dataType: "json",
        data: {},
        async: true
    })
    .done(function (resultado:any) {
        console.log(resultado);
        if(resultado.exito)
        {
            $("#derecha").html(ArmarTablaUsuarios(resultado.dato));
        }
    })
    .fail(function (jqXHR: any, textStatus: any, errorThrown: any)
    {
        let respuesta = JSON.parse(jqXHR.responseText);
        console.log(respuesta.mensaje);
    })
}

function ArmarTablaUsuarios(usuarios : any)
{
    let tabla:string = '<table class="table bg-success table-hover">';
    tabla += `<tr>
        <th>Id</th>
        <th>Correo</th>
        <th>Clave</th>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Perfil</th>
        <th>Foto</th>
    </tr>`;
    usuarios.forEach(usuario => {

        tabla += `<tr>
        <td>${usuario.id}</td>
        <td>${usuario.correo}</td>
        <td>${usuario.clave}</td>
        <td>${usuario.nombre}</td>
        <td>${usuario.apellido}</td>
        <td>${usuario.perfil}</td>
        <td><img src="${usuario.foto}" alt="" width="50px" height="50px"></td>
        </tr>`;
    });
    tabla += "</table>";
    return tabla;
}

function MostrarAutos() : void
{
    VerificarToken();
    $("#izquierda").html("");
    let token = localStorage.getItem("token");
    $.ajax({
        type: 'GET',
        url: API + 'public/autos',
        dataType: "json",
        data: {},
        headers : {token : token},
        async: true
    })
    .done(function (resultado:any)
    {
        console.log(resultado);
        if(resultado.exito)
        {
            if(resultado.dato === null){
                $("#izquierda").html(CrearAlerta(resultado.mensaje, 'warning'));
            }
            else{
                $("#izquierda").html(ArmarTablaAutos(resultado.dato));
            }
        }
    })
    .fail(function (jqXHR: any, textStatus: any, errorThrown: any)
    {
        let respuesta = JSON.parse(jqXHR.responseText);
        console.log(respuesta.mensaje);
    })
}

function ArmarTablaAutos(autos : any)
{
    let tabla:string = '<table class="table bg-danger table-hover">';
    tabla += `<tr>
        <th>Marca</th>
        <th>Color</th>
        <th>Modelo</th>
        <th>Precio</th>
        <th>Eliminar</th>
        <th>Modificar</th>
    </tr>`;
    autos.forEach(auto => {

        tabla += `<tr>
        <td>${auto.marca}</td>
        <td>${auto.color}</td>
        <td>${auto.modelo}</td>
        <td>${auto.precio}</td>
        <td><a href='#' class='btn btn-danger' data-action='eliminar' data-obj_auto='${JSON.stringify(auto)}' title='Eliminar'<i class='bi bi-pencil'></i>Eliminar</a></td>
        <td><a href='#' class='btn btn-success' data-action='modificar' data-obj_auto='${JSON.stringify(auto)}' title='Modificar'><i class='bi bi-pencil'></i>Modificar</a></td>
        </tr>`;
    });
    tabla += "</table>";
    return tabla;
}

function CrearAlerta(mensaje : string, tipo : string = "success") : string
{
    let alerta : string = `<div class="alert alert-${tipo} alert-dismissible fade show" role="alert">
                            <strong>Atencion!</strong> ${mensaje}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>`;
    return alerta;
}
  ////////////////////////////////////////////////
   
  
  /*
  function MostrarUsuarios() {
    let pagina = "./aa/";
    $.ajax({
        url: pagina,
        type: "GET",
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        async: true
    }).done(function (resultado) {
        let listaElementos = resultado;
        let html = '<table class="table table-hover table-responsive ">';
        html += '<tr><th>Correo</th><th>Nombre</th><th>Apellido</th><th>Perfil</th><th>Foto</th></tr>';
        listaElementos.forEach((element: { correo: any; nombre: any; apellido: any; perfil: any; foto: any; }) => {
            html += '<tr>';
            html += '<td>' + element.correo + '</td>';
            html += '<td>' + element.nombre + '</td>';
            html += '<td>' + element.apellido + '</td>';
            html += '<td>' + element.perfil + '</td>';
            html += '<td>' + '<img src="src/fotos/' + element.foto + '" width="50px" height="50px"></td>';
            html += '</tr>';
        });
        html += '</table>'
        $("#derecha").html(html);
    }).fail(function (jqXHR, textStatus, errorThrown) {
        let respuesta = jqXHR.responseJSON;
        console.log(respuesta);
        let html = '<div class="alert alert-danger alert-dissmisable">' + "Error, no se ha podido cargar la Tabla" + '</div>';
        $("#divAlert").html(html);
    });
  }
  function MostrarAutos() {
    let pagina = "./public/autos";
    $.ajax({
        url: pagina,
        type: "GET",
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        async: true
    }).done(function (resultado) {
        let listaElementos = resultado;
        let html = '<table class="table table-hover table-striped table-responsive">';
        html += '<tr><th>Marca</th><th>color</th><th>Modelo</th><th>Precio</th><th>Eliminar</th><th>Modificar</th></tr>';
        listaElementos.forEach((element: { marca: any; color: any; modelo: any; precio: any; id: any; }) => {
            html += '<tr>';
            html += '<td>' + element.marca + '</td>';
            html += '<td>' + element.color + '</td>';
            html += '<td>' + element.modelo + '</td>';
            html += '<td>' + element.precio + '</td>';
            html += '<td>' + '<input type="button" value="Eliminar" onclick="EliminarAuto(' + element.id + ')" class="btn-danger form-control">' + '</td>';
            html += '<td>' + "<input type='button' value='Modificar' onclick='ModificarAuto(" + JSON.stringify(element) + ")' class='btn-info form-control'>" + '</td>';
            html += '</tr>';
        });
        html += '</table>'
        $("#izquierda").html(html);
    }).fail(function (jqXHR, textStatus, errorThrown) {
        let respuesta = jqXHR.responseJSON;
        console.log(respuesta);
        let html = '<div class="alert alert-danger alert-dissmisable">' + "Error, no se ha podido cargar la Tabla" + '</div>';
        $("#divAlert").html(html);
    });
  }
  function EliminarAuto(id: any) {
    let confirmar = confirm("Esta seguro que desea eliminar este Auto?")
    if (confirmar) {
        let pagina = "./public/";
        let jwt = localStorage.getItem("jwt");
        let json = { "id_auto": id };
        let token = { "token": jwt };
        $.ajax({
            url: pagina,
            type: "DELETE",
            headers: token,
            data: json,
            dataType: "json",
            cache: false,
            //contentType:false,
            //processData:false,
            async: true
        }).done(function (resultado) {
            MostrarAutos();
        }).fail(function (jqXHR, textStatus, errorThrown) {
            let respuesta = jqXHR.responseJSON;
            let estado = jqXHR.status;
            if (!respuesta.exito) {
                if (estado == 403) {
                    location.href = "login.html";
                    return;
                }
                let html = '<div class="alert alert-warning alert-dissmisable">' + "ACCION SOLO PROPIETARIOS " + respuesta.mensaje + '</div>';
                $("#divAlert").html(html);
            }
            console.log("no se pudo eliminar")
        });
    }
  }
  function ModificarAuto(json: any) {
    let html;
    html = '<div class="container-fluid" style="background-color: darkcyan; ">';
    html += '<form action="" >';
    html += '<div class="form-group" >';
    html += '<div class="row mt-1" >';
    html += '<div class="col-1 mt-3" ><label for="txtMarca" class="fas fa-trademark "></label></div>';
    html += '<div class="col mt-3"><input type="text" id="txtMarca" class="form-control" value="' + json.marca + '" placeholder="Marca"></div></div>';
    html += '<div class="row mt-1">';
    html += '<div class="col-1"><label for="txtColor" class="fas fa-palette "></label></div>';
    html += '<div class="col"><input type="text" id="txtColor" class="form-control" value="' + json.color + '" placeholder="Color"></div></div>';
    html += '<div class="row mt-1">';
    html += '<div class="col-1"><label for="txtModelo" class="fas fa-car"></label></div>';
    html += '<div class="col"><input type="text" id="txtModelo" class="form-control" value="' + json.modelo + '" placeholder="Modelo"></div></div>';
    html += '<div class="row mt-1">';
    html += '<div class="col-1"><label for="txtPrecio" class="fas fa-dollar-sign "></label></div>';
    html += '<div class="col"><input type="text" id="txtPrecio" class="form-control" value="' + json.precio + '" placeholder="Precio"></div>';
    html += '</div>';
    html += '<div class="row mt-3">';
    html += '<div class="col ml-5"><input type="button" value="Modificar" class="btn-success form-control" onclick="ObtenerdatosModificar(' + json.id + ')"></div>';
    html += '<div class="col mr-5"><input type="reset" value="Limpiar" class="btn-warning form-control" ></div>';
    html += '</div>';
    html += '</div></form></div>';
    $("#izquierda").html(html);
  }
  function ObtenerdatosModificar(id: any) {
    let marca = $("#txtMarca").val();
    let color = $("#txtColor").val();
    let modelo = $("#txtModelo").val();
    let precio = $("#txtPrecio").val();
    let pagina = "./public/";
    let cadenaJson = JSON.stringify({ "marca": marca, "color": color, "modelo": modelo, "precio": precio });
    let jwt = localStorage.getItem("jwt");
    let token = { "token": jwt };
    let auto = { "auto": cadenaJson, "id_auto": id };
    $.ajax({
        url: pagina,
        type: "PUT",
        headers: token,
        dataType: "json",
        cache: false,
        data: auto,
        //contentType:false,
        //processData:false,
        async: true
    }).done(function (resultado) {
        console.log(resultado);
        MostrarAutos();
    }).fail(function (jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.responseText);
        let respuesta = JSON.parse(jqXHR.responseText);
        if (!respuesta.exito) {
            let respuesta = jqXHR.responseJSON;
            let estado = jqXHR.status;
            if (!respuesta.exito) {
                if (estado == 403) {
                    location.href = "login.html";
                    return;
                }
                let html = '<div class="alert alert-warning alert-dissmisable">' + "ACCION SOLO ENCARGADOS " + respuesta.mensaje + '</div>';
                $("#divAlert").html(html);
            }
        }
    });
  }*/
  
  function AltaAutos() {
    let html;
    html = '<div class="container-fluid" style="background-color: darkcyan; ">';
    html += '<form action="" >';
    html += '<div class="form-group" >';
    html += '<div class="row mt-1" >';
    html += '<div class="col-1 mt-3" ><label for="txtMarca" class="fas fa-trademark "></label></div>';
    html += '<div class="col mt-3"><input type="text" id="txtMarca" class="form-control"  placeholder="Marca"></div></div>';
    html += '<div class="row mt-1">';
    html += '<div class="col-1"><label for="txtColor" class="fas fa-palette "></label></div>';
    html += '<div class="col"><input type="text" id="txtColor" class="form-control" placeholder="Color"></div></div>';
    html += '<div class="row mt-1">';
    html += '<div class="col-1"><label for="txtModelo" class="fas fa-car"></label></div>';
    html += '<div class="col"><input type="text" id="txtModelo" class="form-control" placeholder="Modelo"></div></div>';
    html += '<div class="row mt-1">';
    html += '<div class="col-1"><label for="txtPrecio" class="fas fa-dollar-sign "></label></div>';
    html += '<div class="col"><input type="text" id="txtPrecio" class="form-control" placeholder="Precio"></div>';
    html += '</div>';
    html += '<div class="row mt-3">';
    html += '<div class="col ml-5"><input type="button" value="Agregar" class="btn-success form-control" onclick="AgregoUno()"></div>';
    html += '<div class="col mr-5"><input type="reset" value="Limpiar" class="btn-warning form-control" ></div>';
    html += '</div>';
    html += '</div></form></div>';
    $("#izquierda").html(html);
  }
  
  function AgregoUno() {
    let marca = $("#txtMarca").val();
    let color = $("#txtColor").val();
    let modelo = $("#txtModelo").val();
    let precio = $("#txtPrecio").val();
  
    let auto = JSON.stringify({ "marca": marca, "color": color, "modelo": modelo, "precio": precio });
    let form = new FormData()
  
    form.append("auto", auto);
    $.ajax({
        url: API + "public/",
        type: "post",
        data: form,
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        async: true
    }).done(function (resultado) {
        console.log(resultado);
        MostrarAutos();
  
    }).fail(function (jqXHR, textStatus, errorThrown) {
        let respuesta = jqXHR.responseJSON;
        console.log(jqXHR);
        alert(respuesta.mensaje);
    });
  }
  
  /*
  /////////////////////////////////////////////////////7
  /// <reference path="../node_modules/@types/jquery/index.d.ts" />
  //tsc --outfile ./FRONTEND/principal.js ./FRONTEND/principal.ts
  namespace Manejadora
  {
      export class Principal
      {
          public static ArmarAlert(mensaje:string, tipo:string = "success"):string
          {
              let alerta:string = '<div id="alert_' + tipo + '" class="alert alert-' + tipo + ' alert-dismissable">';
              alerta += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
              alerta += '<span class="d-inline-block text-truncate" style="max-width: 450px;">' + mensaje + ' </span></div>';
              return alerta;
          }
          public static ArmarTablaUsuarios(usuario: { tabla: { correo: string; nombre: string; apellido: string; perfil: string; foto: string; }[]; }):string 
          {
              let tabla:string = '<table class="table table-hover" style="background-color: rgb(47, 153, 47)">';
              tabla += '<br><tr><th>CORREO</th><th>NOMBRE</th><th>APELLIDO</th><th>PERFIL</th><th>FOTO</th></tr>';
          
              usuario.tabla.forEach((element: { correo: string; nombre: string; apellido: string; perfil: string; foto: string; }) => 
              {
                  console.log(element);
                  tabla += '<tr><td>'+element.correo+'</td><td>'+element.nombre+'</td><td>'+element.apellido+'</td><td>'+element.perfil+'</td><th><img src="./BACKEND/fotos/'+element.foto+'" height=50 width=50 ></img></td></tr>';
              });
          
              tabla += "</table>";
          
              return tabla;
          }
          public static ArmarFormAuto(accion : string, auto ?) : void
          {
              $("#divResultado").html("");
              
              let marca = "";
              let color = "";
              let modelo = "";
              let precio = "";
              let funcion = "";
              let titulo = "";
              
              switch(accion)
              {
                  case "modificar":
                      let objJson = JSON.parse(auto);
                      funcion = "Manejadora.Principal.ModificarAuto("+ objJson.id +")";
                      titulo = "Modificar";
                      marca = objJson.marca;
                      color = objJson.color;
                      modelo = objJson.modelo;
                      precio = objJson.precio;
                      break;
                  case "agregar":
                      funcion =  "Manejadora.Principal.AgregarAuto(event)";
                      titulo = "Agregar";
                      break;
              }
              let form:string = '<br>\
                                  <div class="row justify-content-center">\
                                      <div class="col-md-8">\
                                          <form style="background-color: darkcyan" class="well col-md-10">\
                                              <br>\
                                              <div class="form-group">\
                                                  <div class="input-group">\
                                                      <span class="input-group-addon"><i class="fa fa-trademark"></i></span>\
                                                      <input type="text" class="form-control" id="marca" placeholder="Marca" value="'+marca+'">\
                                                  </div>\
                                              </div>\
                                              <div class="form-group">\
                                                  <div class="input-group">\
                                                      <span class="input-group-addon"><i class="fa fa-paint-brush"></i></span>\
                                                      <input type="text" class="form-control" id="color" placeholder="Color" value="'+color+'">\
                                                  </div>\
                                              </div>\
                                              <div class="form-group">\
                                                  <div class="input-group">\
                                                      <span class="input-group-addon"><i class="fa fa-car"></i></span>\
                                                      <input type="text" class="form-control" id="modelo" placeholder="Modelo" value="'+modelo+'">\
                                                  </div>\
                                              </div>\
                                              <div class="form-group">\
                                                  <div class="input-group">\
                                                      <span class="input-group-addon"><i class="fa fa-usd"></i></span>\
                                                      <input type="number" class="form-control" id="precio" placeholder="Precio" value="'+precio+'">\
                                                  </div>\
                                              </div>\
                                              <div class="row">\
                                                  <div class="col-sm-6 col-xs-12">\
                                                      <button type="submit" class="btn btn-block btn-success" id="btnModificar" onclick='+ funcion +'>'+ titulo +'</button>\
                                                  </div>\
                                                  <div class="col-sm-6 col-xs-12">\
                                                      <button type="reset" class="btn btn-block btn-warning">Limpiar</button>\
                                                  </div>\
                                              </div>\
                                              <br>\
                                          </form>\
                                      </div>\
                                  </div><br>';
              $("#divAutos").html(form);
          }
          public static ArmarTablaAutos(auto: any):string 
          {
              let tabla:string = '<table class="table table-hover" style="background-color: rgb(223, 71, 71)">';
              tabla += '<br><tr><th>MARCA</th><th>COLOR</th><th>MODELO</th><th>PRECIO</th><th colspan="2">ACCIONES</th></tr>';
              let accion = "modificar";
              auto.tabla.forEach((element: { marca: string; color: string; modelo: string; precio: string; id: string; }) => 
              {
                  tabla += '<tr><td>'+element.marca+'</td><td>'+element.color+'</td><td>'+element.modelo+'</td><td>'+element.precio+'</td>';
                  tabla += '<td><button type="button" class="btn btn-danger" id="btnEliminar" onclick="Manejadora.Principal.EliminarAuto('+ element.id +')">Eliminar</button></td>';
                  tabla += '<td><button type="button" class="btn btn-info" id="btnModificar" onclick=Manejadora.Principal.ArmarFormAuto(\''+accion+'\',\''+ JSON.stringify(element) +'\')>Modificar</button></td>';                                                    
              });
          
              tabla += "</table>";
          
              return tabla;
          }
          public static ListadoUsuarios():void 
          {
              //LIMPIO EL CONTENIDO DEL DIV    
              $("#divResultado").html("");
          
              $.ajax
              ({
                  type: 'GET',
                  url: "./BACKEND/",
                  dataType: "json",
                  data: {},
                  async: true
              })
              .done(function (resultado) 
              {
                  //MUESTRO EL RESULTADO DE LA PETICION
                  console.log(resultado);
                  let tabla:string = Principal.ArmarTablaUsuarios(resultado);
                  $("#divUsuario").html(tabla);
              })
              .fail(function (resultado) 
              {
                  let alerta:string = Principal.ArmarAlert(resultado.responseJSON.mensaje, "danger");
                  $("#divResultado").html(alerta);
              });    
          }
          public static ListadoAutos():void 
          {
              //LIMPIO EL CONTENIDO DEL DIV    
              $("#divResultado").html("");
          
              $.ajax
              ({
                  type: 'GET',
                  url: "./BACKEND/autos",
                  dataType: "json",
                  data: {},
                  async: true
              })
              .done(function (resultado) 
              {
                  //MUESTRO EL RESULTADO DE LA PETICION
                  let tabla:string = Principal.ArmarTablaAutos(resultado);
                  $("#divAutos").html(tabla);
              })
              .fail(function (resultado) 
              {
                  let alerta:string = Principal.ArmarAlert(resultado.responseJSON.mensaje, "danger");
                  $("#divResultado").html(alerta);
              });    
          }
          public static AgregarAuto(e : any) : void
          {
              e.preventDefault();
              let marca = $("#marca").val();
              let color = $("#color").val();
              let modelo = $("#modelo").val();
              let precio = $("#precio").val();
              let dato : any = {
                  color : color,
                  marca : marca,
                  precio : precio,
                  modelo : modelo
              }
              $.ajax({
                  type: 'POST',
                  url: "./BACKEND/",
                  dataType: "json",
                  data: {"json":JSON.stringify(dato)},
                  async: true
              })
              .done(function(resultado)
              {
                  let alerta:string = Principal.ArmarAlert(resultado.mensaje);
                  $("#divResultado").html(alerta);
              })
              .fail(function (resultado:any) 
              {
                  let alerta:string = Principal.ArmarAlert(resultado.responseJSON.mensaje, "danger");
                  $("#divResultado").html(alerta);
              })  
          }
          public static EliminarAuto(id: any) : void
          {
              let jwt = localStorage.getItem("jwt");
              if (confirm("Â¿Desea eliminar el auto?"))
              {
                  $.ajax
                  ({
                      type: 'DELETE',
                      url: "./BACKEND/",
                      dataType: "json",
                      data: {"id":id},
                      headers : {"token":jwt},
                      async: true
                  })
                  .done(function(resultado)
                  {
                      Principal.ListadoAutos();
                  })
                  .fail(function(resultado)
                  {
                      if(resultado.responseJSON.mensaje == "Expired token")
                      {
                          window.location.replace("./login.html");
                      }
                      else
                      {
                          let alerta:string = Principal.ArmarAlert(resultado.responseJSON.mensaje, "danger");
                          $("#divResultado").html(alerta);
                      }
                  })
              }
          }
          public static ModificarAuto(id: any) : void
          {
              let jwt = localStorage.getItem("jwt");
              let marca = $("#marca").val();
              let color = $("#color").val();
              let modelo = $("#modelo").val();
              let precio = $("#precio").val();
              let dato : any = {
                  id : id,
                  marca : marca,
                  color : color,
                  modelo : modelo,
                  precio : precio
              }
              $.ajax({
                  type: 'PUT',
                  url: "./BACKEND/",
                  dataType: "json",
                  data: {"json":JSON.stringify(dato)},
                  headers : {"token":jwt},
                  async: true
              })
              .done(function(resultado)
              {
                  let alerta:string = Principal.ArmarAlert(resultado.mensaje);
                  $("#divResultado").html(alerta);
              })
              .fail(function (resultado:any) 
              {
                  if(resultado.responseJSON.mensaje == "Expired token")
                  {
                      window.location.replace("./login.html");
                  }
                  else
                  {
                      let alerta:string = Principal.ArmarAlert(resultado.responseJSON.mensaje, "danger");
                      $("#divResultado").html(alerta);
                  }
              })  
          }
          public static ObtenerAutosFiltrados():void 
          {
              $.ajax
              ({
                  type: 'GET',
                  url: "./BACKEND/autos",
                  dataType: "json",
                  data: {},
                  async: true
              })
              .done(function (resultado) 
              {
                  let objFiltrado = resultado.tabla.filter((auto: { precio: number; }, index: any, array: any) => auto.precio > 250888);
                  let autos : any ={tabla : objFiltrado}
                  let tabla:string = Principal.ArmarTablaAutos(autos);
                  $("#divAutos").html(tabla);
              })
              .fail(function (resultado) 
              {
                  let alerta:string = Principal.ArmarAlert(resultado.responseJSON.mensaje, "danger");
                  $("#divResultado").html(alerta);
              });
          }
          public static ObtenerPreciosPromedio():void 
          {
              $.ajax
              ({
                  type: 'GET',
                  url: "./BACKEND/autos",
                  dataType: "json",
                  data: {},
                  async: true
              })
              .done(function (resultado) 
              {
                  let promedioPrecio = resultado.tabla.reduce((anterior: number, actual: { precio: string; }, index: any, array: any) => {
                      return anterior + parseFloat(actual.precio);
                  }, 0) / resultado.tabla.length;
                  let alerta:string = Principal.ArmarAlert("El promedio de todos los autos es: " + promedioPrecio, "info");
                  $("#divResultado").html(alerta);
              })
              .fail(function (resultado) 
              {
                  let alerta:string = Principal.ArmarAlert(resultado.responseJSON.mensaje, "danger");
                  $("#divResultado").html(alerta);
              });
          }
          public static ObtenerEmpleados():void
          {
              $.ajax
              ({
                  type: 'GET',
                  url: "./BACKEND/",
                  dataType: "json",
                  data: {},
                  async: true
              })
              .done(function (resultado) 
              {
                  let objFiltrado = resultado.tabla.map((empleado: { nombre: any; foto: any; }, index: any, array: any) => {
                      let data : any = {nombre : empleado.nombre,foto : empleado.foto}
                      return data;
                  });
                  let tabla:string = '<table class="table table-hover" style="background-color: rgb(47, 153, 47)">';
                  tabla += '<br><tr><th>NOMBRE</th><th>FOTO</th></tr>';
              
                  objFiltrado.forEach((element: { nombre: string; foto: string; }) => {
                      tabla += '<tr><td>'+element.nombre+'</td><th><img src="./BACKEND/fotos/'+element.foto+'" height=50 width=50 ></img></td></tr>';
                  });
              
                  tabla += "</table>";
                 
                  $("#divUsuario").html(tabla);
              })
              .fail(function (resultado) 
              {
                  let alerta:string = Principal.ArmarAlert(resultado.responseJSON.mensaje, "danger");
                  $("#divResultado").html(alerta);
              }); 
          }
      }
  }
  */
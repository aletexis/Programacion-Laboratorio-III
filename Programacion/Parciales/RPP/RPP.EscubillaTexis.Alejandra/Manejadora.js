/// <reference path="./node_modules/@types/jquery/index.d.ts" />
var RecuperatorioPrimerParcial;
(function (RecuperatorioPrimerParcial) {
    var Manejadora = /** @class */ (function () {
        function Manejadora() {
        }
        Manejadora.AgregarCocinero = function () {
            var especialidad = $("#especialidad").val().toString();
            var email = $("#correo").val().toString();
            var clave = parseInt($("#clave").val().toString());
            var pagina = "./BACKEND/AltaCocinero.php";
            var form = new FormData();
            form.append("especialidad", especialidad);
            form.append("email", email);
            form.append("clave", clave.toString());
            $.ajax({
                url: pagina,
                type: 'POST',
                dataType: "json",
                contentType: false,
                processData: false,
                data: form,
                async: true
            }).done(function (retJSON) {
                if (retJSON.exito) {
                    console.log("Agregado Correcamente");
                    console.log(retJSON.mensaje);
                    alert("Agregado Correctamente");
                }
            }).fail(function (jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
            });
        };
        Manejadora.MostrarCocineros = function () {
            $.ajax({
                url: './BACKEND/ListadoCocineros.php',
                type: 'GET',
                cache: false,
                processData: false
            }).done(function (retJSON) {
                var arrayJson = JSON.parse(retJSON);
                var tabla = "";
                tabla += "<table border=1 style='width:100%' text-aling='center'> <thead>";
                tabla += "<tr>";
                tabla += "<th>Especialidad</th>";
                tabla += "<th>Correo</th>";
                tabla += "<th>Clave</th>";
                tabla += "</tr> </thead>";
                for (var i = 0; i < arrayJson.length; i++) {
                    tabla += "<tr>";
                    tabla += "<td>" + arrayJson[i]["especialidad"] + "</td>";
                    tabla += "<td>" + arrayJson[i]["email"] + "</td>";
                    tabla += "<td>" + arrayJson[i]["clave"] + "</td>";
                    console.log(arrayJson[i]);
                    tabla += "</tr>";
                }
                tabla += "</table>";
                $("#divTabla").html(tabla);
            }).fail(function (jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
            });
        };
        Manejadora.VerificarExistencia = function () {
            var correo = $("#correo").val().toString();
            var clave = $("#clave").val().toString();
            $.ajax({
                url: './BACKEND/VerificarCocinero.php',
                type: 'POST',
                dataType: "html",
                data: { "email": correo, "clave": clave },
                async: true
            }).done(function (retJSON) {
                var respuesta = JSON.parse(retJSON);
                alert(respuesta.mensaje + JSON.stringify(respuesta.masPopulares));
                console.log(respuesta);
            }).fail(function (jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
            });
        };
        Manejadora.AgregarRecetaSinFoto = function () {
            var nombre = $("#nombre").val().toString();
            var ingrediente = $("#ingredientes").val().toString();
            var tipo = $("#cboTipo").val().toString();
            var form = new FormData();
            form.append("nombre", nombre);
            form.append("ingredientes", ingrediente);
            form.append("tipo", tipo);
            $.ajax({
                url: './BACKEND/AgregarRecetaSinFoto.php',
                type: 'POST',
                dataType: "json",
                data: form,
                async: true,
                contentType: false,
                processData: false
            }).done(function (retJSON) {
                if (retJSON.exito) {
                    console.log("Agregado Correcamente");
                    console.log(retJSON.mensaje);
                    alert("Agregado Correctamente");
                    Manejadora.MostrarRecetas();
                }
            }).fail(function (jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
            });
        };
        Manejadora.MostrarRecetas = function () {
            $.ajax({
                url: './BACKEND/ListadoRecetas.php',
                type: 'GET',
                cache: false,
                processData: false
            }).done(function (retJSON) {
                var lista = JSON.parse(retJSON);
                var tabla = "<table style=\"padding: 20px; margin: 0 auto; width: 900px; text-align: center;\"><tr>\n                    <td colspan=\"6\">\n                    <hr />\n                    </td>\n                    </tr>\n                    <tr>\n                        <td>Id</td>\n                        <td>Nombre</td>\n                        <td>Ingredientes</td>\n                        <td>Tipo</td>\n                        <td>Foto</td>\n                        <td>Acciones</td>\n                    </tr>";
                for (var i = 0; i < lista.length; i++) {
                    var element = lista[i];
                    tabla += "<tr>";
                    tabla += "<td>" + lista[i].id + "</td>";
                    tabla += "<td>" + lista[i].nombre + "</td>";
                    tabla += "<td>" + lista[i].ingredientes + "</td>";
                    tabla += "<td>" + lista[i].tipo + "</td>";
                    if (lista[i].pathFoto == undefined || lista[i].pathFoto == null || lista[i].pathFoto == "") {
                        tabla += "<td>SinFoto</td>";
                    }
                    else {
                        tabla += "<td><img src=\"" + lista[i].pathFoto + "\" height=\"40\" width=\"40\"></td>";
                    }
                    console.log(lista[i]);
                    var objJson = JSON.stringify(lista[i]);
                    console.log(objJson);
                    tabla += "<td><input type='button' onclick='new RecuperatorioPrimerParcial.Manejadora.btnModificar(" + objJson + ")' value='Modificar'</td>";
                    tabla += "<td><input type='button' onclick='new RecuperatorioPrimerParcial.Manejadora.EliminarReceta(" + objJson + ")' value='Eliminar'><td>";
                }
                tabla += "</tr><tr><td colspan=\"6\"><hr /></td></tr>";
                $("#divTabla").html(tabla);
            }).fail(function (jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
            });
        };
        Manejadora.AgregarVerificarReceta = function () {
            var xhr = new XMLHttpRequest();
            var id = $("#id").val().toString();
            var nombre = $("#nombre").val().toString();
            var ingredientes = $("#ingredientes").val().toString();
            var tipo = $("#cboTipo").val().toString();
            var foto = document.getElementById("foto");
            var form = new FormData();
            if ($("#hdnIdModificacion").val().toString() == "true") {
                var json = { "id": id, "nombre": nombre, "ingredientes": ingredientes, "tipo": tipo, "foto": "" };
                console.log(JSON.stringify(json));
                form.append('receta_json', JSON.stringify(json));
                form.append('foto', foto.files[0]);
                $.ajax({
                    url: "./BACKEND/ModificarReceta.php",
                    type: 'POST',
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    data: form,
                    async: true
                }).done(function (retJSON) {
                    if (retJSON.exito) {
                        console.log("Modificado Correcamente");
                        console.log(retJSON.mensaje);
                        alert("Modificado Correctamente");
                        $("#hdnIdModificacion").val("false");
                        Manejadora.MostrarRecetas();
                    }
                    else {
                        alert(retJSON.mensaje);
                        console.log(retJSON.mensaje);
                    }
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
                });
            }
            else {
                form.append('id', id);
                form.append('nombre', nombre);
                form.append('ingredientes', ingredientes);
                form.append('tipo', tipo);
                form.append('foto', foto.files[0]);
                $.ajax({
                    url: './BACKEND/AgregarReceta.php',
                    type: 'POST',
                    dataType: "json",
                    data: form,
                    contentType: false,
                    processData: false,
                    async: true
                }).done(function (retJSON) {
                    if (retJSON.exito) {
                        console.log("Agregado Correcamente");
                        console.log(retJSON.mensaje);
                        alert("Agregado Correctamente");
                        Manejadora.MostrarRecetas();
                    }
                    else {
                        alert(retJSON.mensaje);
                        console.log(retJSON.mensaje);
                    }
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
                });
            }
        };
        Manejadora.EliminarReceta = function (json) {
            console.log(json);
            var form = new FormData();
            form.append('receta_json', JSON.stringify(json));
            form.append('accion', 'borrar');
            $.ajax({
                url: './BACKEND/EliminarReceta.php',
                type: 'POST',
                dataType: "json",
                contentType: false,
                data: form,
                processData: false,
                async: true
            }).done(function (retJSON) {
                if (retJSON.exito) {
                    console.log("Elminado Correcamente");
                    console.log(retJSON);
                    alert("Eliminado Correctamente");
                    Manejadora.MostrarRecetas();
                }
            }).fail(function (jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
            });
        };
        Manejadora.btnModificar = function (json) {
            console.log(json);
            $("#id").val(json["id"]);
            $('#id').prop('readonly', true);
            $("#nombre").val(json["nombre"]);
            $("#ingredientes").val(json["ingredientes"]);
            $("#cboTipo").val(json["tipo"]);
            if (json["pathFoto"] != null && json["pathFoto"] != undefined && json["pathFoto"] != "") {
                $("#imgFoto").attr("src", json["pathFoto"]);
            }
            $("#hdnIdModificacion").val("true");
        };
        Manejadora.ModificarReceta = function () {
            Manejadora.AgregarVerificarReceta();
            $('#id').prop('readonly', false);
            $("#id").val("");
            $("#nombre").val("");
            $("#ingredientes").val("");
            $("#cboTipo").val("Bodegon");
            $("#imgFoto").attr("src", "./receta_default.jpg");
        };
        Manejadora.FiltrarRecetas = function () {
            var nombre = $("#nombre").val().toString();
            var tipo = $("#cboTipo").val().toString();
            var form = new FormData();
            form.append('nombre', nombre);
            form.append('tipo', tipo);
            $.ajax({
                url: './BACKEND/FiltrarReceta.php',
                type: 'POST',
                contentType: false,
                dataType: "json",
                data: form,
                cache: false,
                processData: false,
                async: true
            }).done(function (retJSON) {
                //$("#divTabla").html(retJSON);
                alert("ERROR");
            }).fail(function (jqXHR, textStatus, errorThrown) {
                //alert( jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
                $("#divTabla").html(jqXHR.responseText);
            });
        };
        Manejadora.MostrarRecetasBorradas = function () {
            $.ajax({
                url: './BACKEND/MostrarBorrados.php',
                type: 'GET',
                cache: false,
                processData: false,
                async: true
            }).done(function (retJSON) {
                $("#divTabla").html(retJSON);
            }).fail(function (jqXHR, textStatus, errorThrown) {
                alert(+"\n" + textStatus + "\n" + errorThrown);
            });
        };
        Manejadora.CargarTipoJSON = function () {
            $.ajax({
                url: './BACKEND/obtenerJson.php',
                type: 'GET',
                cache: false,
                processData: false,
                async: true
            }).done(function (retJSON) {
                console.log(JSON.parse(retJSON));
                var lista = JSON.parse(retJSON);
                $('#cboTipo').empty();
                for (var index = 0; index < lista.length; index++) {
                    var opcion = lista[index]["descripcion"];
                    $("<option value=\"" + opcion + "\">" + opcion + "</option>").appendTo("#cboTipo");
                }
            }).fail(function (jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
            });
        };
        return Manejadora;
    }());
    RecuperatorioPrimerParcial.Manejadora = Manejadora;
})(RecuperatorioPrimerParcial || (RecuperatorioPrimerParcial = {}));

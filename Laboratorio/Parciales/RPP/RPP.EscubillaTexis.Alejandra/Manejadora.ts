/// <reference path="./node_modules/@types/jquery/index.d.ts" />

namespace RecuperatorioPrimerParcial
{
    export class Manejadora
    {
        /*AgregarCocinero. Obtiene la especialidad, el email y la clave desde la página cocinero.html y
        se enviará (por AJAX) hacia “./BACKEND/AltaCocinero.php” que creará un objeto de tipo cocinero e
        invocará al método de instancia GuardarEnArchivo(), que agregará al cocinero en ./archivos/cocinero.json.
        Retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.
        Informar por consola y alert el mensaje recibido. */
        public static AgregarCocinero()
        {
            let especialidad = $("#especialidad").val().toString();
            let email = $("#correo").val().toString();
            let clave = parseInt($("#clave").val().toString());
            let pagina : string = "./BACKEND/AltaCocinero.php";
            let form = new FormData();

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
                async: true,
            }).done(function (retJSON)
            {
                if (retJSON.exito)
                {
                    console.log("Agregado exitosamente");
                    console.log(retJSON.mensaje);
                    alert("Agregado exitosamente");
                }
            }).fail(function (jqXHR, textStatus, errorThrown)
            {
                alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
            });

        }

        /*MostrarCocineros. Recuperará (por AJAX) todos los cocineros del archivo cocinero.json y generará un listado dinámico,
        crear una tabla HTML con cabecera (en el FRONTEND) que mostrará toda la información de cada uno de los cocineros.
        Invocar a “./BACKEND/ListadoCocinero.php”, recibe la petición (por GET) y mostrará el listado de todos los cocineros
        en formato JSON. */
        public static MostrarCocineros()
        {
            $.ajax({
                url: './BACKEND/ListadoCocineros.php',
                type: 'GET',
                cache: false,
                processData: false
            }).done(function (retJSON)
            {
                let arrayJson = JSON.parse(retJSON);
                let tabla: string = "";
                tabla += "<table border=1 style='width:100%' text-aling='center'> <thead>";
                tabla += "<tr>";
                tabla += "<th>Especialidad</th>";
                tabla += "<th>Correo</th>";
                tabla += "<th>Clave</th>";
                tabla += "</tr> </thead>";

                for (let i=0; i < arrayJson.length; i++)
                {
                    tabla += "<tr>";
                    tabla += "<td>" + arrayJson[i]["especialidad"] + "</td>";
                    tabla += "<td>" + arrayJson[i]["email"] + "</td>";
                    tabla += "<td>" + arrayJson[i]["clave"] + "</td>";
                    console.log(arrayJson[i]);
                    tabla += "</tr>";
                }

                tabla += "</table>";
                $("#divTabla").html(tabla);
            }).fail(function (jqXHR, textStatus, errorThrown)
            {
                alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
            });


        }

        /*VerificarExistencia. Verifica que el cocinero que se quiere agregar no exista.
        Para ello, invocará (por AJAX) a “./BACKEND/VerificarCocinero.php”.
        Se recibe por POST el email y la clave, si coinciden con algún registro del archivo JSON (VerificarExistencia),
        crear una COOKIE nombrada con el email y la especialidad del cocinero, separado con un guión bajo
        (maru_botana@gmail.com_pastelero) que guardará la fecha actual (con horas, minutos y segundos)
        más el retorno del mensaje del método VerificarExistencia.
        Retornar un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido
        (agregar el mensaje obtenido del método de clase).
        Se mostrará (por consola y alert) lo acontecido. */
        public static VerificarExistencia()
        {
            let correo = $("#correo").val().toString();
            let clave = $("#clave").val().toString();
            
            $.ajax({
                url: './BACKEND/VerificarCocinero.php',
                type: 'POST',
                dataType: "html",
                data: { "email": correo, "clave": clave },
                async: true,
            }).done(function (retJSON)
            {
                let respuesta = JSON.parse(retJSON);
                alert(respuesta.mensaje+JSON.stringify(respuesta.masPopulares));
                console.log(respuesta);
            }).fail(function (jqXHR, textStatus, errorThrown)
            {
                alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
            });

        }

        /*AgregarRecetaSinFoto. Obtiene el nombre, los ingredientes y el tipo desde la página receta.html y
        se enviará (por AJAX) hacia “./BACKEND/AltaRecetaSinFoto.php” que recibe por POST
        el nombre, los ingredientes y el tipo. 
        Se invocará al método Agregar (agrega, a partir de la instancia actual, un nuevo registro en la tabla recetas
        (id, nombre, ingredientes, tipo, foto), de la base de datos recetas_bd. 
        Retorna true, si se pudo agregar, false, caso contrario).
        Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.
        Informar por consola y alert el mensaje recibido. */
        public static AgregarRecetaSinFoto()
        {
            let nombre = $("#nombre").val().toString();
            let ingrediente = $("#ingredientes").val().toString();
            let tipo = $("#cboTipo").val().toString();
            let form = new FormData();
            
            form.append("nombre", nombre);
            form.append("ingredientes", ingrediente);
            form.append("tipo", tipo);
            
            $.ajax({
                url: './BACKEND/AgregarRecetaSinFoto.php',
                type: 'POST',
                dataType: "json",
                data: form,
                async: true,
                contentType:false,
                processData:false
            }).done(function (retJSON)
            {
                if (retJSON.exito)
                {
                    console.log("Agregado exitosamente");
                    console.log(retJSON.mensaje);
                    alert("Agregado exitosamente");
                    Manejadora.MostrarRecetas();
                }
            }).fail(function (jqXHR, textStatus, errorThrown)
            {
                alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
            });
        }

        /*MostrarRecetas. Recuperará (por AJAX) todas las recetas de la base de datos, invocando a “./BACKEND/ListadoRecetas.php”,
        recibe la petición (por GET) y mostrará el listado completo de las recetas (obtenidas de la base de datos)
        en una tabla (HTML con cabecera).
        Invocar al método Traer (retorna un array de objetos de tipo Receta, recuperados de la base de datos.).
        Nota: preparar la tabla (HTML) con una columna extra para que muestre la imagen de la foto (si es que la tiene).
        Informar por consola y alert el mensaje recibido y mostrar el listado en la página (div id='divTabla') */
        public static MostrarRecetas()
        {
            $.ajax({
                url: './BACKEND/ListadoRecetas.php',
                type: 'GET',
                cache: false,
                processData: false
            }).done(function (retJSON)
            {
                let lista = JSON.parse(retJSON);
                let tabla = `<table style="padding: 20px; margin: 0 auto; width: 900px; text-align: center;"><tr>
                    <td colspan="6">
                    <hr />
                    </td>
                    </tr>
                    <tr>
                        <td>Id</td>
                        <td>Nombre</td>
                        <td>Ingredientes</td>
                        <td>Tipo</td>
                        <td>Foto</td>
                        <td>Acciones</td>
                    </tr>`;
                for (let i = 0; i < lista.length; i++)
                {
                    const element = lista[i];
                    tabla += `<tr>`;
                    tabla += `<td>` + lista[i].id + `</td>`;
                    tabla += `<td>` + lista[i].nombre + `</td>`;
                    tabla += `<td>` + lista[i].ingredientes + `</td>`;
                    tabla += `<td>` + lista[i].tipo + `</td>`;
                    
                    if (lista[i].pathFoto == undefined || lista[i].pathFoto == null || lista[i].pathFoto == "")
                    {
                        tabla += `<td>SinFoto</td>`;
                    }
                    else
                    {
                        tabla += `<td><img src="` + lista[i].pathFoto + `" height="40" width="40"></td>`;
                    }

                    console.log(lista[i]);
                    let objJson: string = JSON.stringify(lista[i]);
                    console.log(objJson);
                    tabla += "<td><input type='button' onclick='new RecuperatorioPrimerParcial.Manejadora.btnModificar(" + objJson + ")' value='Modificar'</td>";
                    tabla += "<td><input type='button' onclick='new RecuperatorioPrimerParcial.Manejadora.EliminarReceta(" + objJson + ")' value='Eliminar'><td>";
                }
                tabla += `</tr><tr><td colspan="6"><hr /></td></tr>`;
                $("#divTabla").html(tabla);
            }).fail(function (jqXHR, textStatus, errorThrown)
            {
                alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
            });

        }

        /*AgregarVerificarReceta. Obtiene el nombre, los ingredientes, el tipo y la foto desde la página receta.html y se
        enviará (por AJAX) hacia “./BACKEND/AgregarReceta.php” que recibirá por POST todos los valores: nombre,
        ingredientes, tipo y foto para registrar una receta en la base de datos.
        
        Informar por consola y alert el mensaje recibido.
        Refrescar el listado de recetas 
        
        NOTA: Agregar una columna (Acciones) al listado de recetas que permita: Eliminar y Modificar a la receta elegida.
        Para ello, agregue dos botones (input [type=button]) que invoquen a las funciones EliminarReceta y
        ModificarReceta, respectivamente.*/
        public static AgregarVerificarReceta()
        {
            let xhr: XMLHttpRequest = new XMLHttpRequest();
            let id = $("#id").val().toString();
            let nombre = $("#nombre").val().toString();
            let ingredientes = $("#ingredientes").val().toString();
            let tipo = $("#cboTipo").val().toString();
            let foto: any = (<HTMLInputElement>document.getElementById("foto"));
            let form: FormData = new FormData();
            
            if($("#hdnIdModificacion").val().toString() == "true")
            {
                let json: any = { "id": id, "nombre": nombre, "ingredientes": ingredientes, "tipo": tipo, "foto": "" };
                console.log(JSON.stringify(json));
                form.append('receta_json', JSON.stringify(json));
                form.append('foto', foto.files[0]);
                
                $.ajax({
                    url: "./BACKEND/ModificarReceta.php",
                    type: 'POST',
                    dataType: "json",
                    contentType:false,
                    processData:false,
                    data: form,
                    async: true
                }).done(function(retJSON)
                {
                    if (retJSON.exito)
                    {
                        console.log("Modificado exitosamente");
                        console.log(retJSON.mensaje);
                        alert("Modificado exitosamente");
                        $("#hdnIdModificacion").val("false")
                        Manejadora.MostrarRecetas();
                    }
                    else
                    {
                        alert(retJSON.mensaje);
                        console.log(retJSON.mensaje);
                    }
                }).fail(function (jqXHR, textStatus, errorThrown)
                {
                    alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
                });
            }
            else
            {
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
                    contentType:false,
                    processData:false,
                    async: true
                }).done(function (retJSON)
                {
                    if(retJSON.exito)
                    {
                        console.log("Agregado exitosamente");
                        console.log(retJSON.mensaje);
                        alert("Agregado exitosamente");
                        Manejadora.MostrarRecetas();
                    }
                    else
                    {
                        alert(retJSON.mensaje);
                        console.log(retJSON.mensaje);
                    }
                }).fail(function (jqXHR, textStatus, errorThrown)
                {
                    alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
                });
            }
        }

        /*EliminarReceta. Recibe como parámetro al objeto JSON que se ha de eliminar.
        Pedir confirmación, mostrando nombre y tipo, antes de eliminar.
        Si se confirma se invocará (por AJAX) a “./BACKEND/EliminarReceta.php” 
        Informar por consola y alert lo acontecido.
        Refrescar el listado para visualizar los cambios. */
        public static EliminarReceta(json: object)
        {
            console.log(json);
            let form: FormData = new FormData();

            form.append('receta_json', JSON.stringify(json));
            form.append('accion', 'borrar');

            $.ajax({
                url: './BACKEND/EliminarReceta.php',
                type: 'POST',
                dataType: "json",
                contentType:false,
                data: form,
                processData: false,
                async: true
                
            }).done(function (retJSON)
            {
                if(retJSON.exito)
                {
                    console.log("Elminado exitosamente");
                    console.log(retJSON);
                    alert("Eliminado exitosamente");
                    Manejadora.MostrarRecetas();
                }
            }).fail(function (jqXHR, textStatus, errorThrown)
            {
                alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
            });
        }

        public static btnModificar(json: object)
        {
            console.log(json);
            $("#id").val(json["id"]);
            $('#id').prop('readonly', true);
            $("#nombre").val(json["nombre"]);
            $("#ingredientes").val(json["ingredientes"]);
            $("#cboTipo").val(json["tipo"]);
            
            if(json["pathFoto"] != null && json["pathFoto"] != undefined && json["pathFoto"] != "")
            {
                $("#imgFoto").attr("src", json["pathFoto"]);
            }
            $("#hdnIdModificacion").val("true");
        }

        /*ModificarReceta. Mostrará todos los datos de la receta que recibe por parámetro (objeto JSON), 
        en el formulario, incluida la foto (mostrarla en “imgFoto”). 
        Permitirá modificar cualquier campo, a excepción del id, dejarlo como de sólo lectura.
        Al pulsar el botón Modificar receta se invocará (por AJAX) a “./BACKEND/ModificarReceta.php”
        Refrescar el listado sólo si se pudo modificar, caso contrario, informar (por alert y consola) de lo acontecido. */
        public static ModificarReceta()
        {
            Manejadora.AgregarVerificarReceta();
            $('#id').prop('readonly', false);
            $("#id").val("");
            $("#nombre").val("");
            $("#ingredientes").val("");
            $("#cboTipo").val( "Bodegon" );
            $("#imgFoto").attr("src", "./receta_default.jpg");
        }

        /*FiltrarRecetas. Invocará (por AJAX) a “./BACKEND/FiltrarReceta.php” 
        Refrescar el listado. */
        public static FiltrarRecetas()
        {
            let nombre: any = $("#nombre").val().toString();
            let tipo: any = $("#cboTipo").val().toString();
            let form: FormData = new FormData();

            form.append('nombre', nombre);
            form.append('tipo', tipo);

            $.ajax({
                url: './BACKEND/FiltrarReceta.php',
                type: 'POST',
                contentType:false,
                dataType:"json",
                data: form,
                cache:false,
                processData: false,
                async: true
            }).done(function (retJSON)
            {
                //$("#divTabla").html(retJSON);
                alert("Error!");
            }).fail(function (jqXHR, textStatus, errorThrown)
            {
                //alert( jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
                $("#divTabla").html(jqXHR.responseText);
            });
        }

        /*MostrarRecetasBorradas. Invocará (por AJAX) a “./BACKEND/MostrarBorrados.php” 
        Armar un listado dinámico, crear una tabla HTML con cabecera (en el FRONTEND) que
        mostrará toda la información de cada una de las recetas borradas (con su respectiva foto). */
        public static MostrarRecetasBorradas()
        {
            $.ajax({
                url: './BACKEND/MostrarBorrados.php',
                type: 'GET',
                cache: false,
                processData: false,
                async: true
            }).done(function (retJSON)
            {
                $("#divTabla").html(retJSON);
            }).fail(function (jqXHR, textStatus, errorThrown)
            {
                alert( + "\n" + textStatus + "\n" + errorThrown);
            });

        }

        /*CargarTiposJSON. Cargará (por AJAX) en el combo (cboTipos) con el contenido del archivo
        “./BACKEND/tipos_receta.json”.
        Los tipos no deben estar repetidos en el combo (hacer que se carguen, pero que no se dupliquen). */
        public static CargarTipoJSON()
        {
            $.ajax({
                url: './BACKEND/obtenerJson.php',
                type: 'GET',
                cache: false,
                processData: false,
                async: true
            }).done(function (retJSON)
            {
                console.log(JSON.parse(retJSON));
                let lista= JSON.parse(retJSON);
                $('#cboTipo').empty();

                for (let index = 0; index < lista.length; index++)
                {
                    let opcion = lista[index]["descripcion"];
                    $(`<option value="${opcion}">${opcion}</option>`).appendTo("#cboTipo");                    
                }
            }).fail(function (jqXHR, textStatus, errorThrown)
            {
                alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
            });

        }
    }
}
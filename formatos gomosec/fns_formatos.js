function Principal() {
    Listar();
    $("#btn_guardar").click(Guardar);
    $("#btn_nuevo").click(VaciarForm);
    $("#btn_cargar").click(Cargar);
    $("#refresh_cliente").click(Listar);
    $("#btn_modificar").click(Modificar);



    MostrarObjetos("Ver");
}

// STANDARDS
function OcultarObjetos() {
    $("#btn_cargar").hide();
    $("#btn_guardar").hide();
    $("#btn_actualizar").hide();
    $("#btn_modificar").show();
    $("#btn_editar").hide();
    $("#btn_eliminar").hide();
}


function MostrarObjetos(TipoObjetos) {
    OcultarObjetos();
    if (TipoObjetos == "Ver") {
        $("#btn_modificar").show();
        return;
    }
    if (TipoObjetos == "Crear") {
        $("#btn_cargar").show();
        $("#btn_guardar").show();
        $(".btn_eliminar_row").show();
        return;
    }
    if (TipoObjetos == "Modificar") {
        $("#btn_actualizar").show();
        $("#btn_editar").show();
        $("#btn_cargar").show();
        $("#div_estado").show();
        $(".btn_eliminar_row").show();
        $("#btn_modificar").hide();

        // $("#btn_active").hide();
        return;
    }

    return;
}

function VaciarForm() {
    $("#txt_descripcion").val("");
    $("#txt_observacion").val("");
    $("#txt_estado").val("");
    $("#txt_fechaVigencia").val("");
    $("#btn_guardar").show();
    $("#btn_cargar").show();
    RowDetFormato = [];

    $("#TbodydetallesFormatos").html("");
    $("#btn_editar").hide();
    $("#btn_modificar").hide();
    $("#txt_estado").change(CambioEstado);
}

// END STANDARDS

function Modificar() {
    MostrarObjetos("Modificar");
}

function ConfirmaModificar() {
    GSW_MOSTRAR = 1;
    // OcultarObjetos();
    $id = $(this).attr('value');
    GID = $id;
    $("#txt_estado").change(CambioEstado);
    MostrarDatosEditar("Ver");


}
function ConfirmaEditar() {
  if (GSW_MOSTRAR != 0) {GSW_MOSTRAR = 0;return;}

    // OcultarObjetos();
    $id = $(this).attr('value');
    GID = $id;
    $("#txt_estado").change(CambioEstado);
    MostrarDatosEditar("Modificar");

}

function ModificarRow (){
  GSW_MOSTRAR = 1;
  $id = $(this).attr('value');
  GID = $id;
  $("#txt_estado").change(CambioEstado);
  MostrarDatosEditar("Modificar");
}

function ValidarMostrar(){
  if (GSW_MOSTRAR != 0) {GSW_MOSTRAR = 0;return;}
  $id = $(this).attr('value');
  GID = $id;
  $("#txt_estado").change(CambioEstado);
  MostrarDatosEditar("Ver");
}

function Editar() {
    if (RowDetFormato.length == 0) {
        swal('Error', 'Por favor cargar al menos un producto al formato', 'error');
    } else {

        var descripcion = $("#txt_descripcion").val();
        var observacion = $("#txt_observacion").val();
        var estado = $("#txt_estado").val();
        var fecha = $("#txt_fechaVigencia").val();
        var inputFileImage = document.getElementById("txt_pdf_formato");
        var file = inputFileImage.files[0];


        //para que se lleve bien el archivo se debe subir de esta manera los  paramentros
        var parametros = new FormData();
        parametros.append("Accion", "Editar");
        parametros.append("idformato", GID);
        parametros.append("formato", file);
        parametros.append("descripcion", descripcion);
        parametros.append("observacion", observacion);
        parametros.append("estado", estado);
        parametros.append("fecha", fecha);

        var ArrayModuloFormatos = [];
        for (var i = 0; i < RowDetFormato.length; i++) {
            var Cod = RowDetFormato[i];
            ArrayModuloFormatos.push(JSON.parse('{"Cod":"' + Cod + '"}'));
        }

        var ArrayModuloFormatosString = JSON.stringify(ArrayModuloFormatos);

        parametros.append('ArrayModuloFormatos', ArrayModuloFormatosString);

        $.ajax({
            url: 'mdl_formatos.php',
            type: 'POST',
            //esto tiene que estar para que suba el archivo
            contentType: false,
            //dataType:'html',
            data: parametros,
            //esto tiene que estar para que suba el archivo
            processData: false,
            cache: false,

            success: function(data) {
                //alert(data);
                var DataRow = data.split("º");
                var Titulo = DataRow[0];
                var Respuesta = DataRow[1];
                var Tipo = DataRow[2];

                swal({
                    title: Titulo,
                    text: Respuesta,
                    type: Tipo,
                    icon: Tipo,
                    button: true,
                }).then((willDelete) => {
                    if (Tipo == "success") {
                        $("#closeModal").click();
                        location.reload();

                    }
                });

            },
            error: function(respuesta, status) {

            },
            complete: function(respuesta, status) {}

        });
    }



}


function MostrarDatosEditar(tipomostrar) {
    RowDetFormato=[];
    var parametros = {
        "Accion": "MostrarDatosEditar",
        "Id": GID,
        "botonesMostrar": tipomostrar
    };

    $.ajax({
        // la URL para la petición
        url: 'mdl_formatos.php',
        // especifica si será una petición POST o GET
        type: 'POST',
        // el tipo de información que se espera de respuesta
        dataType: 'json',
        // la información a enviar
        data: parametros,
        // código a ejecutar si la petición es satisfactoria;
        success: function(data) {


            var Titulo = data.array[0]['Titulo'];

            var Respuesta = data.array[0]['Respuesta'];
            var Tipo = data.array[0]['Tipo'];

            var idformatos = data.array[1]['idformatos'];
            var descripcion = data.array[1]['descripcion'];
            var observacion = data.array[1]['observacion'];
            var estado = data.array[1]['estado'];
            var fecha = data.array[1]['fecha'];
            GID = "";
            GID = idformatos;

            $("#txt_descripcion").val(descripcion);
            $("#txt_observacion").val(observacion);
            $("#txt_estado").val(estado);
            $("#txt_fechaVigencia").val(fecha);



            //LLENAR EL ARRRAY
            var ArrayModulo = data.array[1]['ArrayModulos'];

            var SplitArrayModulo = ArrayModulo.split("º");


            for (var i = 0; i < (SplitArrayModulo.length - 1); i++) {
                if(RowDetFormato.indexOf(SplitArrayModulo[i])== -1){
                  RowDetFormato.push(SplitArrayModulo[i]);
                }

            }


            var HTML = data.array[1]['HTML'];
            $("#TbodydetallesFormatos").html(HTML);
            $(".btn_eliminar_row").click(Eliminar_Row);
            $("#btn_editar").click(Editar);
            // MostrarObjetos("Ver");
            var BOTONESAMOSTRAR = data.array[1]['botonesMostrar'];
            // alert(BOTONESAMOSTRAR);
            if (BOTONESAMOSTRAR == "Modificar") {
              MostrarObjetos("Modificar");

            }else {
              MostrarObjetos("Ver");

            }



        },
        // código a ejecutar si la petición falla;
        error: function(respuesta, status) {
            swal('Error', 'Disculpe, se presentó un problema.', 'error');
        },
        // código a ejecutar sin importar si la petición falló o no
        complete: function(respuesta, status) {
            //swal('Petición realizada');
        }
    });
}




function Guardar() {
    if (RowDetFormato.length == 0) {
        swal('Error', 'Por favor cargue al menos un producto al formato', 'error');
    } else {
        var descripcion = $("#txt_descripcion").val();
        var observacion = $("#txt_observacion").val();
        var estado = $("#txt_estado").val();
        var fecha = $("#txt_fechaVigencia").val();
        var inputFileImage = document.getElementById("txt_pdf_formato");
        var file = inputFileImage.files[0];


        //para que se lleve bien el archivo se debe subir de esta manera los  paramentros
        var parametros = new FormData();
        parametros.append("Accion", "Guardar");
        parametros.append("formato", file);
        parametros.append("descripcion", descripcion);
        parametros.append("observacion", observacion);
        parametros.append("estado", estado);
        parametros.append("fecha", fecha);

        var ArrayModuloFormatos = [];
        for (var i = 0; i < RowDetFormato.length; i++) {

            var Cod = RowDetFormato[i];

            ArrayModuloFormatos.push(JSON.parse('{"Cod":"' + Cod + '"}'));
        }

        var ArrayModuloFormatosString = JSON.stringify(ArrayModuloFormatos);

        parametros.append('ArrayModuloFormatos', ArrayModuloFormatosString);

        $.ajax({
            url: 'mdl_formatos.php',
            type: 'POST',
            //esto tiene que estar para que suba el archivo
            contentType: false,
            //dataType:'html',
            data: parametros,
            //esto tiene que estar para que suba el archivo
            processData: false,
            cache: false,

            success: function(data) {
                //alert(data);
                var DataRow = data.split("º");
                var Titulo = DataRow[0];
                var Respuesta = DataRow[1];
                var Tipo = DataRow[2];

                swal({
                    title: Titulo,
                    text: Respuesta,
                    type: Tipo,
                    icon: Tipo,
                    button: true,
                }).then((willDelete) => {
                    if (Tipo == "success") {

                        $("#closeModal").click();
                        location.reload()
                    }
                    if (Tipo == "error") {
                        $("#txt_pdf_formato").focus();
                    }
                });

            },
            error: function(respuesta, status) {

            },
            complete: function(respuesta, status) {}

        });

    }


}


function Listar() {

    var parametros = {
        "Accion": "Listar"
    };
    $.ajax({
        // la URL para la petición
        url: 'mdl_formatos.php',
        // especifica si será una petición POST o GET
        type: 'POST',
        // el tipo de información que se espera de respuesta
        dataType: 'json',
        // la información a enviar
        data: parametros,
        // código a ejecutar si la petición es satisfactoria;
        success: function(data) {

            var Titulo = data.array[0]['Titulo'];
            var Respuesta = data.array[0]['Respuesta'];
            var Tipo = data.array[0]['Tipo'];

            if (Tipo == "success") {
                var IdTabla = data.array[1]['Listado'][0].Id;
                var ClassTr = data.array[1]['Listado'][0].ClassTr;
                var HTML = data.array[1]['Listado'][0].HTML;

                $("#div_listado_formatos").html(HTML);


                $(".btn_eliminar_row_formatos").click(EliminarFormato);

                $("#" + IdTabla).DataTable();

                $("#btn_nuevo").click(VaciarForm);
                // $(".RowFormatos").click(ConfirmaModificar);
                // $(".btn_modificar_row_formatos").click(ConfirmaEditar);

                $("."+ClassTr).click(ValidarMostrar);
                $(".btn_modificar_row_formatos").click(ModificarRow);


                RowDetFormato = [];


            } else {

                var HTML = "<span>No tiene Formatos vinculados a este usuario</span>";

                $("#div_listado_formatos").html(HTML);

            }

        },
        // código a ejecutar si la petición falla;
        error: function(respuesta, status) {
            swal('Error', 'Disculpe, se presentó un problema.', 'error');
        },
        // código a ejecutar sin importar si la petición falló o no
        complete: function(respuesta, status) {
            //swal('Petición realizada');
        }
    });
}


//FUNCION PARA ELIMINAR UN FORMATO **HEYNER CREATE**
function EliminarFormato() {
    var aRemplazar = $(this).attr('id');
    var id=aRemplazar.replace("btn_eliminar_row_formatos","")
    //console.log(id);
    var parametros = {
        "Accion": "Eliminar",
        'Id': id
    };
    $.ajax({
        // la URL para la petición
        url: 'mdl_formatos.php',
        // especifica si será una petición POST o GET
        type: 'POST',
        // el tipo de información que se espera de respuesta
        dataType: 'json',
        // la información a enviar
        data: parametros,
        // código a ejecutar si la petición es satisfactoria;
        success: function(data) {

            var Titulo = data.array[0]['Titulo'];
            var Respuesta = data.array[0]['Respuesta'];
            var Tipo = data.array[0]['Tipo'];

            if (Tipo == "success") {
                swal(Titulo, Respuesta, Tipo);
                Listar();

            } else {


            }

        },
        // código a ejecutar si la petición falla;
        error: function(respuesta, status) {
            swal('Error', 'Disculpe, se presentó un problema.', 'error');
        },
        // código a ejecutar sin importar si la petición falló o no
        complete: function(respuesta, status) {
            //swal('Petición realizada');
        }
    });
}


//funcion para el cambio de color de activo y inactivo de un estado
function CambioEstado() {
    var id = $(this).attr("id");
    ColorEstados(id);
}

function ColorEstados(id) {
    var ValueEstado = $("#" + id).val();

    if (ValueEstado == "ACTIVO") {
        $("#" + id).css({
            "background-color": "#C9FFC9",
            "color": "#29AD29"
        });
    } else {
        if (ValueEstado == "INACTIVO") {
            $("#" + id).css({
                "background-color": "#FFC9C9",
                "color": "#AD2929"
            });
        } else {
            $("#" + id).css({
                "background-color": "#fff",
                "color": "#000"
            });
        }
    }
}

function Cargar() {
    if ($("#txt_modulo").val() == "-1") {
        swal("Por favor seleccione el módulo.");
    } else {

        var IdModulo = $("#txt_producto").val();

        var DescripcionModulo = $("#txt_producto").find('option:selected').text();

        var NewRow = '<tr id = "' + IdModulo + '"><td class="td_texto_table"">' + IdModulo + '</td> <td class="td_texto_table" >' + DescripcionModulo + '</td><td class="td_texto_table" ><span id="eliminar' + IdModulo + '" class="btn_eliminar_row"  style="font-size: 1em; color: Tomato;"><i class="fas fa-minus-circle"></i></span></td></tr>';
        var Cadena = RowDetFormato;
        var Caracter = IdModulo;
        var ExistModulo = Cadena.indexOf(Caracter);
        if (ExistModulo == "-1") {

            $("#TbodydetallesFormatos").append(NewRow);
            RowDetFormato.push(IdModulo);
            $(".btn_eliminar_row").click(Eliminar_Row);
            $("#txt_producto").val("-1");
        } else {
            swal("Este módulo ya ha sido cargado, por favor verifique.");
        }
    }
}

function Eliminar_Row() {
    if ($("#btn_modificar").is(":visible")) {
        swal('Error', 'Por favor seleccione la opcion modificar', 'error')
    } else {
        var MyId = $(this).attr('id');
        MyId = MyId.replace('eliminar', '');
        MyId = MyId.trim()
        //var Numero= parseInt(MyId);
        //saber que tipo de dato es

        var Cadena = RowDetFormato;

        var Caracter = MyId;
        var PosicionRow = Cadena.indexOf(Caracter);
        if (PosicionRow != -1) {
            RowDetFormato.splice(PosicionRow, 1);
            $(this).closest('tr').remove();
        }
    }

}

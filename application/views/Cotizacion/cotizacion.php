<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">LISTADO DE COTIZACIONES</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-3 ">
                <div class="form-group">
                    SUCURSAL
                    <div id="cargarSucursal"></div>
                </div>

                <!--  <div class="form-group">
                   VENDEDOR
                    <div id="dcargarAsesor"></div>
                </div>-->



            </div>

            <div class="col-sm-2 ">

                <div class="form-group">
                    DESDE:
                    <div class="input-group">
                        <input type="date" class="form-control input-sm" id="txtDesde">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    </div>

                </div>
                <!--  <div class="form-group">
                    SERIE VH
                    <input type="text" class="form-control input-sm">
                </div>-->
            </div>
            <div class="col-sm-1 ">
            </div>
            <div class="col-sm-3 ">

                <div class="form-group">
                    HASTA:
                    <div class="input-group">
                        <input type="date" class="form-control input-sm" id="txtHasta">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    </div>

                </div>


            </div>

            <div class="col-sm-1 col-xs-3">
                <br>
                <a href="<?=base_url()?>Cotizacion/Nuevo"><button class="btn-xs btn-primary">NUEVO</button></a>
            </div>
            <div class="col-sm-1 col-xs-3">
                <br>
                <button class="btn-xs btn-success" onclick="buscarCotizacion()">MOSTRAR</button>
            </div>
            <div class="col-sm-1 col-xs-3">
                <br>
                <a href="javascript:exportar()">
                    <button class=" btn-xs btn-outline-dark-green">EXPORTAR</button>
                </a>
            </div>
        </div>
        <div class="row">

            <div class="col-sm-3">
                <div class="form-group">
                    VENDEDOR
                    <div id="dcargarAsesor"></div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    SERIE VH
                    <input type="text" class="form-control input-sm" id="txtSerie">
                </div>
            </div>
        </div>
    </div>
    <div class="box box-primary">

        <!-- /.box-header -->
        <div class="box-body">
            <div id="tablaDatos"></div>
        </div>
        <!-- /.box-body -->
    </div>
</div>
<div id="respuesta">
    respuesta
</div>
<!---MODAL AGREGAR TRABAJO----->
<div class="modal fade" id="modalTrabajo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                AGREGAR TRABAJO
            </div>
            <div class="modal-body">
                <div class="form-group">
                    (<input type="radio" name="radio" value="xreq">) POR REQUERIMIENTO<br>
                    (<input type="radio" name="radio" value="xserv">) POR SERVICIO<br>
                    (<input type="radio" name="radio" value="xorden">) POR ORDEN<br>
                </div>
                <div class="form-group">
                    <input type="text" id="txtidCotizacion">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="btnActualizar">
                        Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
function exportar() {
    location.href = "./Cotizacion/Exportar";
}

function buscarCotizacion() {

    var sucursal = document.getElementById('cboSucursal').value;
    var asesor = document.getElementById('cboAsesor').value;
    var serie = document.getElementById('txtSerie').value;
    var desde = document.getElementById('txtDesde').value;
    var hasta = document.getElementById('txtHasta').value;
    console.log(sucursal + " " + asesor + " " + serie + " " + desde + " " + hasta);
    $.ajax({
        type: 'POST',
        url: '<?=base_url()?>Cotizacion/gestionar',
        data: 'opcion=buscar_x_datos' + '&sucursal=' + sucursal + '&asesor=' + asesor + '&serievh=' + serie +
            '&desde=' + desde + '&hasta=' + hasta,
        success: function(res) {
            $("#tablaDatos").html(res);

        },
        error: function(res) {
            $("#respuesta").html(res);
        }
    });

}
$(document).ready(function() {
    cargarTabla();
    cargarSedes();
    cargarAsesores();
    $("#btnActualizar").click(function() {
        actualizarTrabajo();
    })
    $("#datos_tabla").DataTable({
        scrollY: 400,
        language: {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }

    })
})

function actualizarTrabajo() {
    var cotizacionId = document.getElementById('txtidCotizacion').value;
    var xre = "#xreq" + cotizacionId;
    var xsrv = "#xserv" + cotizacionId;
    var xor = "#xorden" + cotizacionId;
    var estado = "";
    var xreq = $(xre).val();
    var xserv = $(xsrv).val();
    var xorden = $(xor).val();
    if (xreq == 1) {
        estado = "REQUERIMIENTO";
    }
    if (xserv == 1) {
        estado = "SERVICIO";
    }
    if (xorden == 1) {
        estado = "ORDEN";
    }
    $.ajax({
        type: "post",
        url: "<?=base_url()?>Cotizacion/gestionar",
        data: "opcion=actualizar_trabajo" + "&xreq=" + xreq + "&xserv=" + xserv +
            "&xorden=" + xorden + "&cotizacionID=" + cotizacionId + "&estado=" + estado,
        success: function(res) {
            if (res == 1) {
                alertify.success("Actualizado");
                window.setTimeout(function() {
                    location.href = "<?=base_url()?>Cotizacion/";
                }, 500);

            } else {
                alertify.error("error en el servidor");
            }
        }
    })
    $("#respuesta").html(xreq + " " + xserv + " " + xorden);
}

$("input[type=radio]").click(function() {
    var id = $("#txtidCotizacion").val();
    var valor = "#" + $(this).val() + id;
    var $box = $(this);
    var $boxcheck = $(valor);
    if ($box.is(":checked")) {
        var group = "input:checkbox[name='" + $box.attr("name") + "']";
        var groupcheck = "input:checkbox[name='" + $boxcheck.attr("name") + "']";
        $(group).prop("checked", false);
        $(groupcheck).prop("checked", false);
        $(groupcheck).prop("value", '0');
        $box.prop("checked", true);
        $boxcheck.prop("checked", true);
        $boxcheck.prop("value", '1');
    } else {
        $box.prop("checked", false);
    }

    $("#respuesta").html(valor);
    $(valor).prop("checked", true);
});





function cargarSedes() {
    $.ajax({
        type: "post",
        url: "<?=base_url()?>Cotizacion/gestionar",
        data: "opcion=llenarSucursal",
        success: function(res) {
            $("#cargarSucursal").html(res);
        }
    })
}

function cargarAsesores() {
    $.ajax({
        type: "post",
        url: "<?=base_url()?>Cotizacion/gestionar",
        data: "opcion=llenarAsesores",
        success: function(res) {
            $("#dcargarAsesor").html(res);
        }
    })
}

function cargarTabla() {
    $.ajax({
        type: "post",
        url: "<?=base_url()?>Cotizacion/gestionar",
        data: "opcion=cargar_tablaCotizacion",
        success: function(res) {
            $("#tablaDatos").html(res);
        }
    })

}



function activar(id, evt, estado) {

    if (evt.which == 3) {
        if (estado == 1) {
            if (confirm('Cambiar a estado PENDIENTE?')) {
                $.ajax({
                    type: "post",
                    url: "<?=base_url()?>Cotizacion/gestionar",
                    data: "opcion=cotizacion_pendiente" +
                        "&cotizacionID=" + id,
                    success: function(res) {
                        if (res == 1) {
                            alertify.success("Actualizado");
                            window.setTimeout(function() {
                                location.href = "<?=base_url()?>Cotizacion/";
                            }, 500);
                        } else {
                            alertify.error("error en el servidor");
                        }
                        $("#respuesta").html(res);

                    }
                })

            }
        }
        if (estado == 2) {
            if (confirm('Cambiar a estado APROBADO?')) {
                $.ajax({
                    type: "post",
                    url: "<?=base_url()?>Cotizacion/gestionar",
                    data: "opcion=cotizacion_aprobar" +
                        "&cotizacionID=" + id,
                    success: function(res) {
                        if (res == 1) {
                            alertify.success("Actualizado");
                            window.setTimeout(function() {
                                location.href = "<?=base_url()?>Cotizacion/";
                            }, 500);

                        } else {
                            alertify.error("error en el servidor");
                        }
                        $("#respuesta").html(res);
                    }
                })
            }
        }


    }
}
</script>
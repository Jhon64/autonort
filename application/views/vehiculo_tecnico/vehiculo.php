<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">PROGRAMACION VEHICULO - TECNICO</h3>
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
                        <input type="date" class="form-control input-sm">
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
                        <input type="date" class="form-control input-sm">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    </div>

                </div>


            </div>


            <div class="col-sm-1 col-xs-3">
                <br>
                <button class="btn-xs btn-success">MOSTRAR</button>
            </div>
            <div class="col-sm-1 col-xs-3">
                <br>
                <button class="btn-xs btn-success">EXPORTAR</button>
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
                    <input type="text" class="form-control input-sm">
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
</div>
<div id="respuesta">
    respuesta
</div>
<!---MODAL AGREGAR TRABAJO----->
<div class="modal fade" id="modalTrabajo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm " role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                PLANIFICACIÓN - INICIO
            </div>
            <div class="modal-body">
                <div class="form-group" style="padding-left: 40px;padding-right: 40px">
                    <div class="input-group">
                        <input type="date" class="form-control input-sm" id="fechaPlanificacion"
                            name="fechaPlanificacion">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-1 " align="right"><button class="btn-xs btn-primary"
                                onclick="actualizarTrabajo()">GUARDAR</button> </div>
                        <div class="col-sm-2"></div>
                        <div class="col-sm-1">
                            <button class="btn-danger btn-xs" data-dismiss="modal" aria-label="Close">CANCELAR</button>
                        </div>
                    </div>
                </div>
                <input type="text" id="txtidCotizacion">


                <div class="modal-footer">

                </div>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    cargarTabla();
    cargarSedes();
    cargarAsesores();
    $("#btnActualizar").click(function() {
        actualizarTrabajo();
    })
})

function actualizarTrabajo() {
    var cotizacionId = document.getElementById('txtidCotizacion').value;
    var fechaPlanificacion = document.getElementById('fechaPlanificacion').value;

    $.ajax({
        type: "post",
        url: "<?=base_url()?>Cotizacion/gestionar",
        data: "opcion=actualizar_fechatrabajo" + "&fechaPlanificacion=" + fechaPlanificacion +
            "&cotizacionID=" + cotizacionId,
        success: function(res) {

            if (res == 1) {
                alertify.success("Actualizado");
                window.setTimeout(function() {
                    location.href = "<?=base_url()?>Planificacion/";
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
        data: "opcion=cargar_tablaPlanificacion",
        success: function(res) {
            $("#tablaDatos").html(res);
        }
    })

}



function activar(id, evt) {
    //   alert("entrando"+evt.switch);
    $("#txtidCotizacion").val(id);
    $("#txtidCotizacion").val(id);
    if (evt.which == 3) {
        if (confirm("Desea asignar Trabajo?")) {
            $("#modalTrabajo").modal("show");
        }

    }
}
</script>
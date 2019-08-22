<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">LISTADO DE PLANIFICACION</h3>
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
<!---MODAL AGREGAR Planificacion----->
<div class="modal fade" id="modalPlanificacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
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
                        <input type="datetime-local" class="form-control input-sm" id="fechaPlanificacion"
                            name="fechaPlanificacion">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-1 " align="right"><button class="btn-xs btn-primary"
                                onclick="actualizarPlanificacion()">GUARDAR</button> </div>
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
})

function buscarCotizacion() {

    var sucursal = document.getElementById('cboSucursal').value;
    var asesor = document.getElementById('cboAsesor').value;
    var serie = document.getElementById('txtSerie').value;
    var desde = document.getElementById('txtDesde').value;
    var hasta = document.getElementById('txtHasta').value;
    console.log("sucursal: " + sucursal + " asesor: " + asesor + " serie: " + serie + " desde: " + desde + " hasta: " +
        hasta);
    $.ajax({
        type: 'POST',
        url: '<?=base_url()?>Planificacion/gestionar',
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

function actualizarPlanificacion() {
    var cotizacionId = document.getElementById('txtidCotizacion').value;
    var fechaPlanificacion = document.getElementById('fechaPlanificacion').value;

    $.ajax({
        type: "post",
        url: "<?=base_url()?>Planificacion/gestionar",
        data: "opcion=actualizar_fechaPlanificacion" + "&fechaPlanificacion=" + fechaPlanificacion +
            "&cotizacionID=" + cotizacionId,
        success: function(res) {
            if (res == 1) {
                alertify.success("Actualizado");
                window.setTimeout(function() {
                    location.href = "<?=base_url()?>Planificacion/";
                }, 500);

            } else {
                alertify.error("error en el servidor");
                $("#respuesta").html(res);
            }

        }
    })

}





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
        url: "<?=base_url()?>Planificacion/gestionar",
        data: "opcion=cargar_tablaPlanificacion",
        success: function(res) {
            $("#tablaDatos").html(res);
        }
    })

}



function planificar(id, evt) {
    //   alert("entrando"+evt.switch);
    $("#txtidCotizacion").val(id);
    if (evt.which == 3) {
        if (confirm("Desea asignar Fecha de Planificación?")) {
            $("#modalPlanificacion").modal("show");
        }

    }
}
</script>
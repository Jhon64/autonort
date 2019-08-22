<style>
.menu ul {
    list-style: none;
    list-style-type: none;
    list-style-position: outside;
}

.menu li {
    line-height: 30px;
    font-size: 16px;
    cursor: pointer;
}

.menu {
    width: 250px;
    position: absolute;
    border: 1px solid black;

    -moz-box-shadow: 0 0 5px #888;
    -webkit-box-shadow: 0 0 5px#888;
    box-shadow: 0 0 5px #888;
}
</style>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">PROGRAMACION VEHICULO-CONTROLADOR</h3>
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
                <button class="btn-xs btn-success" onclick="buscarCotizacion()">MOSTRAR</button>
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

<ul id="menu" class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
    <li>
        <a href="#" onclick="redireccionar_programar()">PROGAMACIÓN DE VEHICULO</a>
        <a href="#" onclick="redireccionar_detener()">DETENER PROGRAMACION</a>
        <a href="#" onclick="redireccionar_terminar()">TERMINAR TRABAJO</a>

</ul>



<div id="respuesta">
    respuesta
</div>



<script type="text/javascript">
var idCotizacion = 0;
$(document).on('click', '', function() {
    $("#menu").hide();
})
$(document).ready(function() {
    cargarTabla();
    cargarSedes();
    cargarAsesores();
    $(document).bind("contextmenu", function(e) {
        return false;
    });
    $("#menu").hide();
})

function redireccionar_programar() {
    location.href = "<?=base_url()?>Vehiculo_Controlador/programacion/" + idCotizacion;
}

function redireccionar_detener() {
    location.href = "<?=base_url()?>Vehiculo_Controlador/detener/" + idCotizacion;
}

function redireccionar_terminar() {
    location.href = "<?=base_url()?>Vehiculo_Controlador/terminar/" + idCotizacion;
}

function desplegar(id, evt) {
    idCotizacion = id;
    if (evt.which == 3) {
        $("#menu").css("top", evt.pageY - 20);
        $("#menu").css("left", evt.pageX - 20);
        $("#menu").show();
    }
}

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
        url: '<?=base_url()?>Vehiculo_Controlador/gestionar',
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
        url: "<?=base_url()?>Vehiculo_Controlador/gestionar",
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
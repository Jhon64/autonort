<input type="text" name="txtCotizacionID" id="txtCotizacionID" value="<?= $cotizacionID;?>" hidden>

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">ASIGNACIÓN</h3>
    </div>

    <div class="row">
        <div class="col-sm-12" style="background-color: #0a0a0a;height: 5px"> </div>
    </div><br>
    <div class="container">
        <div id="cabecera"></div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-12" style="background-color: #0a0a0a;height: 5px"> </div>
        </div><br>
        <div class="row ">
            <div class="col-sm-4" style="background-color: ghostwhite">
                <br>
                <div class="box box-danger">
                    <div class="box-header">
                        <h>BUSCAR</h>

                    </div>
                    <div class="box-body">
                        <label>Técnico: <input type="text" onchange="buscar_tecnicos(this.value)"></label>
                        <table class="table" id="tabla_buscar">
                            <thead>
                                <th style="width: 10px">Asignar</th>
                                <th>TECNICO</th>
                                <th>CARGO</th>
                            </thead>
                            <tbody id="cuerpo">

                            </tbody>
                        </table>

                        <br>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>

            <div class="col-sm-1"></div>

            <div class="col-sm-6" style="background-color:ghostwhite ">
                <br>
                <div class="row">

                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">F. INICIO</span>
                                <input type="date" class="form-control" id="txtFinicio" required>
                            </div>

                        </div>


                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">H.INICIO</span>
                                <input type="time" class="form-control" id="txtHinicio" name="txtHinicio" required>
                            </div>

                        </div>
                    </div>

                    <div class="col-sm-6 ">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon" >F. FIN</span>
                                <input type="date" id="txtFfin" name="txtFfin" required class="form-control">
                            </div>

                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">H. FIN</span>
                                <input type="time" class="form-control" id="txtHfin" name="txtHfin" required>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row ">
                    <div class="col-sm-8" style="background-color: ghostwhite">
                        <div class="box box-danger">

                            <div class="box-body">

                                <table class="table" id="tabla_asignada">
                                    <thead id="0">
                                    <tr id="0">
                                        <th style="width: 10px">Eliminar</th>
                                        <th>TECNICO</th>
                                        <th>CARGO</th>
                                    </tr>

                                    </thead>
                                    <tbody>


                                    </tbody>
                                </table>
                                <br>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                    <div class="col-sm-1"></div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <button class="btn-xs btn-success">EDITAR</button>
                        </div>
                        <div class="form-group">
                            <button class="btn-xs btn-primary" onclick="guardar_programacion()">GUARDAR</button>
                        </div>
                        <div class="form-group">
                            <button class="btn-xs btn-danger">ELIMINAR</button>
                        </div>
                        <br>
                    </div>
                </div>

            </div>
        </div>
    </div>


</div>

<div id="res">res</div>
<script>

$(document).ready(function() {
    cargar_cabecera();
    cargar_tecnicos();
});

function guardar_programacion() {
    var cotizacionID=document.getElementById("txtCotizacionID").value;
    var fInicio=document.getElementById("txtFinicio").value;
    var HInicio=document.getElementById("txtHinicio").value;
    var fFin=document.getElementById("txtFfin").value;
    var HFin=document.getElementById("txtHfin").value;

    if (fInicio==""){alertify.error("ingresar Fecha Inicio")}
    if (fFin==""){alertify.error("ingresar Fecha Fin")}
    if (HInicio==""){alertify.error("ingresar Hora Inicio")}
    if (HFin==""){alertify.error("ingresar Hora Inicio")}

    var cadenaID="";
    var arID=[];

    for (i = 0; i < $("#tabla_asignada").find("tr").length; i++) {
        cadenaID =parseInt($("#tabla_asignada").find("tr").eq(i).attr("id"));
        arID.push(cadenaID);
    }
    if(arID.length==1){
        alert("seleccionar técnicos");
    }
    console.log(arID);
    $.ajax({
        url:'<?=base_url()?>Vehiculo_Controlador/registrar_programacion',
        data:{tecnicos:arID,fInicio:fInicio,fFin:fFin,HInicio:HInicio,HFin:HFin,cotizacionID:cotizacionID},
        type:'post',
        success:function (res) {
            $("#res").html(res);
        }
    })
}

function seleccionar(id) {
    if ($("#" + id).is(":checked")) {
        var tr = $("#" + id).parents("tr").appendTo("#tabla_asignada tbody");
    } else {
        var tr = $("#" + id).parents("tr").appendTo("#tabla_buscar tbody");
    }
}

function asignar() {

    if ($(1).is(":checked")) {
        var tr = $(1).parents("tr").appendTo("#tabla_asignada tbody");
    } else {
        var tr = $(1).parents("tr").appendTo("#tabla_buscar tbody");
    }

}



function cargar_tecnicos() {

    $.ajax({
        type: 'POST',
        url: '<?=base_url()?>Vehiculo_Controlador/gestionar',
        data: {
            opcion: "cargar_tecnicos"
        },
        success: function(res) {
            $("#cuerpo").html(res);

        },
        error: function(res) {
            $("#res").html(res);
        }
    });
}

function buscar_tecnicos(tecnico) {
    var valor = tecnico;
    $.ajax({
        type: 'POST',
        url: '<?=base_url()?>Vehiculo_Controlador/gestionar',
        data: {
            valor: valor,
            opcion: "buscar_tecnicos"
        },
        success: function(res) {
            $("#cuerpo").html(res);

        },
        error: function(res) {
            $("#res").html(res);
        }
    });
}

function cargar_cabecera() {
    var cotizacionID = document.getElementById('txtCotizacionID').value;
    $.ajax({
        type: 'POST',
        url: '<?=base_url()?>Vehiculo_Controlador/gestionar',
        data: {
            cotizacionID: cotizacionID,
            opcion: "mostrar_cabecera"
        },
        success: function(res) {
            $("#cabecera").html(res);

        },
        error: function(res) {
            $("#cabecera").html(res);
        }
    });
}
</script>
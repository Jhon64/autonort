<input type="text" name="txtCotizacionID" id="txtCotizacionID" value="<?= $cotizacionID;?>" hidden>
<br>
<div class="container">
    <div class="box">
        <div class="box-body">
            <div id="cabecera_detener"></div>
            </div>

            <!----tablas ---->
            <br>
            <div class="row">
                <div class="col-sm-4">
                    <div class="box">
                        <div class="box-body">
                            <div class="form-group">
                                ESTADO: BAJO SERVICIO
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    Iniciar
                                    <input type="date" class="" placeholder="estado" style="width: 150px">
                                    &nbsp;
                                    <input type="time"  >
                                </div>
                            </div>
                            <div class="form-group">
                                <label> Motivo</label>
                                <textarea class="form-control">

                                   </textarea>
                            </div>

                            <div class="form-group" align="center">
                                <button>
                                    INICIAR
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-sm-7">
                    <div class="box">
                        <div class="box-body">

                                <h>DETALLE TRABAJO</h>
                                <table class="table table-hover">
                                    <thead style="background-color: #3875d7;color: ghostwhite">
                                    <th>Item</th>
                                    <th>Acción</th>
                                    <th>F.Inicio</th>
                                    <th>H.Inicio</th>
                                    <th>F.Final</th>
                                    <th>H.Final</th>
                                    <th>Técnico</th>
                                    </thead>
                                    <tbody id="cuerpo">

                                    </tbody>

                                </table>


                        </div>

                </div>

            </div>


        </div>

    </div>
    </div>
</div>
<script >
    window.onload=()=>{
        cargar_cabecera();
        cargar_detalle_trabajo();
    }

    function cargar_detalle_trabajo() {
        var cotizacionID =document.getElementById("txtCotizacionID").value;
        $.ajax({
            type:'post',
            url:'<?=base_url()?>Vehiculo_Controlador/gestionar',
            data:{opcion:'cargar_detalle_trabajo',cotizacionID:cotizacionID},
            success:(res)=>{
                $("#cuerpo").html(res);

            }

        })
    }

    function cargar_cabecera() {
        var cotizacionID =document.getElementById("txtCotizacionID").value;
        $.ajax({
            type:'post',
            url:'<?=base_url()?>Vehiculo_Controlador/gestionar',
            data:{opcion:'mostrar_cabecera_detener',cotizacionID:cotizacionID},
            success:(res)=>{
                $("#cabecera_detener").html(res);

            }

        })

    }
</script>
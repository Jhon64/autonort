<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">REGISTRAR PRODUCTOS</h3>
    </div>
    <form id="frm" name="frm" onsubmit="return registrarProducto()" enctype="multipart/form-data">
    <div class="box-body">

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-2">
                                <label>GRUPO </label>
                            </div>
                            <div class="col-sm-7">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-group"></i></span>
                                    <div id="cargarGrupo"></div>
                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-2">
                                <label>SUBGRUPO </label>
                            </div>
                            <div class="col-sm-7">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-group"></i></span>
                                    <div id="cargarSubgrupo"></div>
                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-2">
                                <label>CODIGO </label>
                            </div>
                            <div class="col-sm-7">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-code"></i></span>
                                    <input type="text" autocomplete="off" class="form-control input-sm" placeholder="Código..." id="txtcodigo" name="txtcodigo">
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-2">
                                <label>DESCRIPCIÓN </label>
                            </div>
                            <div class="col-sm-7">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-edit"></i></span>
                                    <input type="text" autocomplete="off" class="form-control input-sm" placeholder="Descripción..." id="txtdescripcion" name="txtdescripcion">
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-2">
                                <label>U.M. </label>
                            </div>
                            <div class="col-sm-7">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa  fa-circle-o"></i></span>
                                    <div id="um"></div>
                                </div>
                            </div>

                        </div>
                    </div>


                </div>

                <div class="col-sm-2">
                    <img id='output' style="height: 150px;width: 150px" name="salida" src="<?=base_url()?>asset/imagenes/default.png">
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        Estado
                        <select class="form-control input-sm" id="cboEstado" name="cboEstado">
                            <option value="1">ACTIVO</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input name="imagen" type="file" class="btn-xs btn-primary"  accept='image/*' onchange='openFile(event)'>
                    </div>
                    <div class="form-group">
                       <!-- <button class="btn-danger btn-xs">Quitar Foto</button>--->
                    </div>
                </div>
            </div>


    </div>

    <div class="row ">
      <!--  <div class="col-sm-4 text-right">
            <button class="btn-sm btn-success">EDITAR</button>
        </div>-->
        <div class="col-sm-12 " align="center">
            <input type="submit" value="GUARDAR" class="btn-primary btn-xs">
        </div>
        <!--
        <div class="col-sm-1 ">
            <button class="btn-danger btn-sm">ELIMINAR</button>
        </div>-->
    </div>
    </form>
    <br><br>
    <div id="xrespuesta"> respuesta</div>

</div>


<script type="text/javascript">


    var openFile = function(event) {
        var input = event.target;

        var reader = new FileReader();
        reader.onload = function(){
            var dataURL = reader.result;
            var output = document.getElementById('output');
            output.src = dataURL;
        };
        reader.readAsDataURL(input.files[0]);
    };


    function registrarProducto() {
        var formData = new FormData($("#frm")[0]);
        $.ajax({
            type:"post",
            data:formData,
            cache: false,
            contentType: false,
            processData: false,
            url:"<?=base_url()?>Producto/subirFoto",
            success:function (res) {
                if (res=="exito") {
                   alertify.success(res);
                   window.setTimeout(function(){location.href = "<?=base_url()?>Producto/"} , 500);
                }else{
                    alertify.error(res);
                }

            }
        });
        return false;

    }

    function cargarCombos() {

        $.ajax({
            url:"<?=base_url()?>Producto/gestionar",
            type:"POST",
            data:"opcion=llenarCombos",
            success:function (res) {
                $("#cargarGrupo").html(res);
            }
        })

    }

    function cargarSubgrupos(){
        $.ajax({
            url: "<?=base_url()?>Producto/gestionar",
            type: "POST",
            data: "opcion=llenarSubgrupos" ,
            success: function (res) {
                $("#cargarSubgrupo").html(res);
            }
        })

    }

    function cargarUM() {
        $.ajax({
            url:"<?=base_url()?>Producto/gestionar",
            type:"POST",
            data:"opcion=llenarUM",
            success:function (res) {
                $("#um").html(res);
            }
        })

    }

    $(document).ready(function () {
        cargarCombos();
        cargarSubgrupos();
        cargarUM();
        alertify.success("Cargando Datos");

    })
</script>


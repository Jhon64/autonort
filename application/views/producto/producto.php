
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">LISTADO DE PRODUCTOS</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4"></div>

        </div>
        <br>
        <div class="row">
            <div class="col-sm-2 ">
                <label for="cboGrupo">Grupo
                <div id="comboGrupo"></div>
                </label>
            </div>
            <div class="col-sm-2 ">
                <label for="cboSubGrupo">Sub Grupo
                <div id="subgrupo"></div>
                </select>
                </label>
            </div>
            <div class="col-sm-3 text-center">
                <br>
                <select id="condicion" class="form-control input-sm" onchange="cargarDatatable()" >
                    <option value="1">ACTIVADO</option>
                    <option value="0">DESACTIVADO</option>
                </select>
            </div>

            <div class="col-sm-1 col-xs-2">
                <br>
                <a href="<?=base_url()?>Producto/Nuevo"><button class="btn-xs btn-primary" >NUEVO </button></a>
            </div>
            <div class="col-sm-1 col-xs-2">
                <br>
                <button class="btn-xs btn-success" id="btnMostrar" onclick="filtrar()">MOSTRAR</button>
            </div>
            <div class="col-sm-1 col-xs-2">
                <br>
                <button class="btn-xs btn-success">EXPORTAR</button>
            </div>
        </div>

    </div>

    <div class="box">
        <div class="box-header">

        </div>
        <!-- /.box-header -->
        <div class="box-body">

            <div class="row">
                <div class="col-sm-12">
                    <div id="datatable_productos">

                    </div>
                </div>

            </div>
        </div>
        <!-- /.box-body -->
    </div>
</div>

<!----Modal Editar Productos---->
<div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog  " role="document" >
        <div class="modal-content ">
            <form id="frmEditar" onsubmit="return editarProducto(this)" enctype="multipart/form-data">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                EDITAR PRODUCTOS
            </div>
            <div class="modal-body">

                    <div class="form-group" style="padding-left: 40px;padding-right: 40px">
                        <div class="input-group" >
                            <span class="input-group-addon">CÓDIGO:</i></span>
                            <input type="text" class="form-control input-sm" id="txtCodigo" required name="txtCodigo" autocomplete="off">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                        </div>
                    </div>
                    <div class="form-group" style="padding-left: 40px;padding-right: 40px" >
                        <div class="input-group">
                            <span class="input-group-addon">Descripción:</i></span>
                            <input type="text" class="form-control input-sm"  id="txtDescripcion" name="txtDescripcion" required  autocomplete="off">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                        </div>
                    </div>
                    <div class="form-group" style="padding-left: 40px;padding-right: 40px" >
                        <div class="input-group">
                            <span class="input-group-addon">GRUPO:</i></span>
                            <div id="edGrupo"></div>
                            <span class="input-group-addon"><i class="glyphicon glyphicon-pencil" ></i></span>
                        </div>
                    </div>
                    <div class="form-group" style="padding-left: 40px;padding-right: 40px" >
                        <div class="input-group">
                            <span class="input-group-addon">SUBGRUPO</i></span>
                            <div id="edsubgrupo"></div>
                            <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                        </div>
                    </div>

                    <div class="form-group" style="padding-left: 40px;padding-right: 40px" >
                        <div class="input-group">
                            <span class="input-group-addon">UM</i></span>
                            <div id="edUM"></div>
                            <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                        </div>
                    </div>

                    <div class="form-group" style="padding-left: 40px;padding-right: 40px" >
                        <div class="input-group">
                            <input type="text" id="idProducto" name="idProducto"  autocomplete="off" readonly>
                        </div>
                    </div>



            </div>
                <div class="modal-footer">
                    <input type="submit" value="GUARDAR" class="btn-xs btn-primary">
                    <button type="button" class="btn-sm "  data-dismiss="modal" aria-label="Close">CANCELAR</button>
                </div>

            </form>
        </div>
    </div>
</div>


<div id="xres"></div>

<script type="text/javascript">

    function editarProducto(frm) {

        var codigo=frm.txtCodigo.value;
        var descripcion=frm.txtDescripcion.value;
        var grupo=frm.cboGrupo.value;
        var subgrupo=frm.cboSubgrupo.value;
        var id=frm.idProducto.value;
        var um=frm.cboUM.value;
        alert(id);

        $.ajax({
            url:"<?=base_url()?>Producto/gestionar",
            type:"POST",
            data:"opcion=editarProducto"+"&codigo="+codigo+"&descripcion="+descripcion+"&grupo="+grupo
            +"&subgrupo="+subgrupo+"&productoID="+id+"&um"+um,
            success:function (res) {
                $("#xres").html(res);
                if (res==1){
                    alertify.success("Actualizado");
                    window.setTimeout(function () {
                       location.href="<?=base_url()?>Producto/";
                    },500);

                }
                if (res==0) {
                    alertify.error("datos ya estan registrados");
                }

            }
        });





        return false;

    }

    function llenarDatos(id,codigo,descripcion) {

        $("#idProducto").val(id);
        $("#txtDescripcion").val(descripcion);
        $("#txtCodigo").val(codigo);
        cargarCombosE();
        cargarSubgruposE();
        cargarUM("edUM");
        $("#modalEditar").modal("show");

    }

    function activar(id,descripcion) {

        if (confirm("seguro de activar "+ descripcion+ "?? ")){
            $.ajax({
                url:"<?=base_url()?>Producto/gestionar",
                type:"POST",
                data:"opcion=activar"+"&productoID="+id,
                success:function (res) {
                    if (res==1){
                        location.href="<?=base_url()?>Producto/";
                    }
                }
            });
            alertify.success("Activando...");
        } else {
            alertify.error("Cancelando...");
        }


    }

    function desactivar(id,descripcion) {

        if (confirm("seguro de desactivar "+ descripcion+ "?? ")){
            $.ajax({
                url:"<?=base_url()?>Producto/gestionar",
                type:"POST",
                data:"opcion=desactivar"+"&productoID="+id,
                success:function (res) {
                  if (res==1){
                      location.href="<?=base_url()?>Producto/";
                  }
                }
            });
        } else {
            alertify.error("Cancelando...");
        }


    }

    function filtrar() {
        var grupo=$("#cboGrupo").val();
        var subgrupo=$("#cboSubgrupo").val();
        var estado=$("#condicion").val();
        $.ajax({
            url:"<?=base_url()?>Producto/gestionar",
            type:"POST",
            data:"opcion=filtrarBusqueda"+"&GrupoID="+grupo+"&SubgrupoID="+subgrupo,
            success:function (res) {
                $("#datatable_productos").html(res);
            }
        })

    }
    
    function cargarCombosE() {
        $.ajax({
            url:"<?=base_url()?>Producto/gestionar",
            type:"POST",
            data:"opcion=llenarCombos",
            success:function (res) {
                $("#edGrupo").html(res);
            }
        })

    }
    function cargarCombos() {
        $.ajax({
            url:"<?=base_url()?>Producto/gestionar",
            type:"POST",
            data:"opcion=llenarCombos",
            success:function (res) {
                $("#comboGrupo").html(res);
            }
        })

    }



    function cargarUM(ubicacion) {
        $.ajax({
            url:"<?=base_url()?>Producto/gestionar",
            type:"POST",
            data:"opcion=llenarUM",
            success:function (res) {
                $("#edUM").html(res);
            }
        })

    }

    function cargarSubgrupos(){
            $.ajax({
                url: "<?=base_url()?>Producto/gestionar",
                type: "POST",
                data: "opcion=llenarSubgrupos" ,
                success: function (res) {
                    $("#subgrupo").html(res);
                }
            })

    }

    function cargarSubgruposE(){
        $.ajax({
            url: "<?=base_url()?>Producto/gestionar",
            type: "POST",
            data: "opcion=llenarSubgrupos" ,
            success: function (res) {
                $("#edsubgrupo").html(res);
            }
        })

    }


    function cargarDatatable(){
        alertify.success("OBTENIENDO DATOS")
        estado=$("#condicion").val();

        $.ajax({
            type:"POST",
            url:"<?=base_url()?>Producto/gestionar",
            data:"opcion=obtener_productos"+"&condicion="+estado,
            success:function (r) {
                $("#datatable_productos").html(r);
            }

        })

    }


    $(document).ready(function () {
        cargarCombos('comboGrupo','subgrupo','Mostrar');
        cargarDatatable();
        cargarSubgrupos();

    })
</script>

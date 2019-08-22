<?php date_default_timezone_set ( 'America/lima' ) ?>
<style>
#content {
    position: absolute;
    min-height: 50%;
    width: 80%;
    top: 20%;
    left: 5%;
}

.selected {
    cursor: pointer;
}

.selected:hover {
    background-color: #0585C0;
    color: red;
}

.seleccionada {
    background-color: #0585C0;
    color: white;
}
</style>

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">REGISTRAR COTIZACIONES</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-9">

            </div>
            <div class="col-sm-2 ">
                Estado

                <select id="txtestado" name="txtestado" class="form-control input-sm">
                    <option value="2">PENDIENTE</option>
                </select>
            </div>


        </div>
        <div class="row">
            <div class="col-sm-1 text-center">
                SUCURSAL<br><button class="text-center">
                    <span class="fa fa-circle-o"></span>
                </button>

            </div>
            <div class="col-sm-3">
                <br>
                <div class="input-group">

                    <span class="input-group-addon"><i class="fa  fa-map-marker"></i></span>
                    <div id="sucursal"></div>

                </div>
            </div>

            <div id="documento"></div>


            <div class="col-sm-2">
                FECHA
                <div class="input-group">
                    <input type="text" class="form-control input-sm" name="txtcalendar" id="txtcalendar"
                        value="<?= date('Y-m-d H:i:s')?>" readonly>
                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12" style="background-color: blue;height: 5px"> </div>
    </div><br>

    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">CLIENTE</span>
                            <input type="text" class="form-control" placeholder="IDCLIENTE.." id="txtidcliente"
                                name="txtidclientes" autocomplete="off" onkeyup="mostrarCliente(this.value)">
                            <div id="datosCliente"></div>
                        </div>

                    </div>


                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">DESCRIPCION</span>
                            <input type="text" class="form-control" required placeholder="Descripción"
                                id="txtdescripcion" name="txtdescripcion" autocomplete="off">
                        </div>

                    </div>
                </div>

                <div class="col-sm-4 ">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">VENDEDOR</span>
                            <div id="vendedores"></div>
                        </div>

                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">SERIE VH</span>
                            <input required type="text" class="form-control" maxlength="4" placeholder="Serie VH..."
                                name="txtSerie" id="txtSerie" autocomplete="off">
                        </div>

                    </div>
                </div>
                <!---  <div class="col-sm-4">
                    VEHICULO
                    <input type="text" name="txtvehiculo" id="txtvehiculo" maxlength="10" required>
                </div>-->
            </div>


        </div>
    </div>
    <div class="box">
        <div class="box-body">
            <div class="row ">
                <div class="col-sm-8 " style="background-color: ghostwhite">
                    <div class="box box-danger">
                        <div class="box-header">
                            <h3 class="box-title">DATOS DE LOS ACCESORIOS</h3>

                        </div>
                        <div class="box-body">
                            <table id="datos_tabla" class="table table-striped table-bordered nowrap"
                                style="width:100%">
                                <thead STYLE="background-color: lightgrey;color: white">
                                    <tr>
                                        <td>Item</td>
                                        <td>Producto</td>
                                        <td>Descripcion</td>
                                        <td>U.M.</td>
                                        <td>Cantidad</td>
                                        <td>P.Unitario</td>
                                        <td>Subtotal</td>
                                        <td>Impuesto</td>
                                        <td>Importe</td>
                                    </tr>


                                </thead>
                                <tbody>


                                </tbody>

                            </table>
                        </div>

                        <!-- /.box-body -->
                    </div>

                </div>
                <div class="col-sm-1"></div>
                <div class="col-sm-2 " style="background-color:ghostwhite ">
                    ITEMS
                    <br><br>
                    <div style="border-color: black;border-collapse: inherit;border-width: 5px;">
                        <div class="form-group " align="center">
                            <button class="btn-xs btn-block" style="width: 75px" id="btnAgregar"
                                onclick="cargarModalAgregar()"><span
                                    class="glyphicon glyphicon-plus-sign"></span></button>
                            AGREGAR
                        </div>
                        <div class="form-group " align="center">
                            <button class="btn-xs btn-block" style="width: 75px" id="btnEliminarFila"><span
                                    class="glyphicon glyphicon-remove-sign"></span></button>
                            ELIMINAR
                        </div>
                        <!-- <div class="form-group " align="center">
                         <button class="btn-xs btn-block" style="width: 75px" onclick="eliminarTodasFilas()"><span class="glyphicon glyphicon-remove-sign" ></span></button>
                         ELIMINAR TODOS
                     </div>-->

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row ">
        <div class="col-sm-4  col-xs-1 text-right">
            <button class="btn-sm btn-success" name="btneditar">EDITAR</button>
        </div>
        <div class="col-sm-1 col-xs-6">
            <button class="btn-sm btn-primary" onclick="guardarCotizacion()">GUARDAR</button>
        </div>

        <div class="col-sm-1 col-xs-6">
            <button class="btn-sm btn-danger">ELIMINAR</button>
        </div>

    </div>
    <br><br>


</div>
<?php

?>


<div class="modal fade" id="modalAgregarProducto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog  " role="document">
        <!-- <form id="frmagregar" onsubmit="return agregar(this)">--->
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>

            </div>
            <div class="modal-body">

                <div class="form-group" style="padding-left: 40px;padding-right: 40px">
                    <div class="input-group">
                        <span class="input-group-addon">Producto:</i></span>
                        <input type="text" class="form-control input-sm" placeholder="Codigo Producto..."
                            onkeyup="buscarProducto(this.value)" required name="txtproductoCodigo"
                            id="txtproductoCodigo" autocomplete="off">

                        <div id="resCodigo"></div>
                        <span class="input-group-addon"><i class="fa fa-plus"></i></span>
                    </div>
                </div>

                <!--  <div class="form-group" style="padding-left: 40px;padding-right: 40px">
                    <div class="input-group" >
                        <span class="input-group-addon">Descripcion:</i></span>
                        <input type="text" class="form-control input-sm" placeholder="Descripción..." id="txtDescripcion" name="txtDescripcion"  required>
                        <div id="resCodigo"></div>
                        <span class="input-group-addon"><i class="fa fa-plus"></i></span>
                    </div>
                </div>-->

                <div class="form-group" style="padding-left: 40px;padding-right: 40px">
                    <div class="input-group">
                        <span class="input-group-addon">U.M</i></span>
                        <div id="cargarUM"></div>
                        <span class="input-group-addon"><i class="fa fa-plus"></i></span>
                    </div>
                </div>
                <div class="form-group" style="padding-left: 40px;padding-right: 40px">
                    <div class="input-group">
                        <span class="input-group-addon">CANTIDAD</i></span>
                        <input type="text" class="form-control input-sm" id="txtCantidad" autocomplete="off"
                            name="txtCantidad" required onkeyup="calcularImporte()">
                        <span class="input-group-addon"><i class="fa fa-cart-plus"></i></span>
                    </div>
                </div>
                <div class="form-group" style="padding-left: 40px;padding-right: 40px">
                    <div class="input-group">
                        <span class="input-group-addon">P.UNITARIO</i></span>
                        <input type="text" class="form-control input-sm" id="txtpuni" name="txtpuni" required
                            onkeyup="calcularImporte()" autocomplete="off">
                        <span class="input-group-addon"><i class="fa fa-money"></i></span>
                    </div>
                </div>
                <div class="form-group" style="padding-left: 40px;padding-right: 40px">
                    <div class="input-group">
                        <span class="input-group-addon">SUBTOTAL</i></span>
                        <input type="text" class="form-control input-sm" id="txtSubtotal" name="txtSubtotal" readonly
                            required autocomplete="off">
                        <span class="input-group-addon"><i class="fa fa-money"></i></span>
                    </div>
                </div>
                <div class="form-group" style="padding-left: 40px;padding-right: 40px">
                    <div class="input-group">
                        <span class="input-group-addon">IMPUESTO</i></span>
                        <input type="text" class="form-control input-sm" id="txtImpuesto" name="txtImpuesto" required
                            onkeyup="calcularImporte()" autocomplete="off">
                        <span class="input-group-addon"><i>%</i></span>
                    </div>
                </div>

                <div class="form-group" style="padding-left: 40px;padding-right: 40px">
                    <div class="input-group">
                        <span class="input-group-addon">IMPORTE</i></span>
                        <input type="text" class="form-control input-sm" id="txtImporte" required autocomplete="off">
                        <span class="input-group-addon"><i class="fa fa-money"></i></span>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn-sm btn-primary" id="btnGuardar"
                        onclick="agregar()">agregar</button>
                    <button type="button" class="btn-sm " data-dismiss="modal" aria-label="Close">CANCELAR</button>
                </div>

            </div>
        </div>
        <!-- </form>---->
    </div>
</div>


<div id="respuestas">respuesta</div>


<script type="text/javascript">
var cont = 0;
var id_fila_selected = [];


function registrar_series() {
    //obetenemos el valor de la serie
    var serie = $("#txtnumero").val();
    //contamos cuantos caracteres tiene
    var seriechar = serie.length;
    //convertimos a entero y sumamos 1
    var correlativo = parseInt(serie) + 1;
    //convertimos a string para contar cuantos espacion ocupara el correlativo
    var longCorrelativo = correlativo.toString().length;

    var ceros = "";
    for (var i = 0; i < (seriechar - longCorrelativo); i++) {
        ceros += "0";
    }

    //vamos a hacer la serie de 4 digitos de la tabla series
    var serie = "";
    for (var i = 0; i < 4 - longCorrelativo; i++) {
        serie += "0";
    }
    var stringCorrelativo = correlativo.toString();
    var stringSerie = serie + stringCorrelativo;
    var devolverNumeroSerie = ceros + stringCorrelativo;
    console.log(stringSerie);
    console.log(devolverNumeroSerie);

    $.ajax({
        type: "post",
        data: "opcion=guardar_serie" + "&serie=" + stringSerie + "&nroDocumento=" + devolverNumeroSerie +
            "&estado=1" + "&documento=COV",
        url: "<?=base_url()?>Cotizacion/gestionar",
        success: function(data) {
            window.setTimeout(function() {
                location.href = "<?= base_url()?>Cotizacion";
            }, 500)
        },
        error: function(data) {
            $("#respuestas").html(data);
        }
    });

}


function registrarDetalleCotizacion(cotizacionID) {
    var productoID = document.getElementsByClassName("txtProductoIDT");
    var descripcion = document.getElementsByClassName("txtDescripcionT");
    var um = document.getElementsByClassName("txtUmT");
    var cantidad = document.getElementsByClassName("txtCantidadT");
    var precio = document.getElementsByClassName("txtPrecioT");
    var subtotal = document.getElementsByClassName("txtSubtotalT");
    var impuesto = document.getElementsByClassName("txtImpuestoT");
    var importe = document.getElementsByClassName("txtImporteT");
    var aProductoID = [];
    var aDescripcion = [];
    var aUM = [];
    var aCantidad = [];
    var aPrecio = [];
    var aSubtotal = [];
    var aImpuesto = [];
    var aImporte = [];
    var acotizacionID = [];
    for (var i = 0; i < productoID.length; ++i) {
        if (typeof productoID[i].value !== "undefined") {
            aProductoID.push(productoID[i].value);
            aDescripcion.push(descripcion[i].value);
            aUM.push(um[i].value);
            aCantidad.push(cantidad[i].value);
            aPrecio.push(precio[i].value);
            aSubtotal.push(subtotal[i].value);
            aImpuesto.push(impuesto[i].value);
            aImporte.push(importe[i].value);
            acotizacionID.push(cotizacionID);
        }
    }
    $.ajax({
        url: "<?=base_url()?>Cotizacion/detalleCotizacion",
        type: "post",
        data: "opcion=registrar_detalleCotizacion" + "&productoID=" + aProductoID + "" +
            "&descripcion=" + aDescripcion + "&um=" + aUM + "&cantidad=" + aCantidad + "&precio=" + aPrecio +
            "&subtotal=" + aSubtotal + "&impuesto=" + aImpuesto + "&importe=" + aImporte + "&cotizacionID=" +
            acotizacionID,
        success: function(res) {
            alertify.success(res);
        },
        error: function(res) {
            $("#respuesta").html("error " + res);
        }
    });


}

function contarFilas_tabla() {
    var filas = $("#datos_tabla tr").length;
}

function guardarCotizacion() {
    var sucursal = $("#cboSucursal").val();
    var idDocumento = $("#cboCov").val();
    var nroDocumento = $("#txtnumero").val();

    var fecha = $("#txtcalendar").val();
    var idCliente = $("#txtidcliente").val();
    var descripcion = $("#txtdescripcion").val();
    var asesor = $("#cboAsesor").val();
    var serievh = $("#txtSerie").val();
    var estado = $("#txtestado").val();
    var vehiculo = null;
    var cantidadFilasDetalle = $("#datos_tabla tr").length;
    alert(cantidadFilasDetalle + " " + vehiculo);
    if (nroDocumento == "" || idCliente == "" || descripcion == "" || vehiculo == "" || serievh == "") {
        alertify.error("llenar todos los campos");
    } else {
        if (cantidadFilasDetalle == 1) {
            alertify.error("llenar Tabla de Accesorios");
        } else {
            $.ajax({
                type: 'post',
                data: "opcion=guardar_cotizacion" + "&sucursal=" + sucursal +
                    "&nroDocumento=" + nroDocumento + "&idDocumento=" + idDocumento + "&fechaRegistro=" +
                    fecha +
                    "&clienteID=" + idCliente + "&descripcion=" + descripcion + "&asesor=" + asesor +
                    "&serievh=" + serievh +
                    "&estado=" + estado + "&documento=" + idDocumento +
                    "&vehiculo=" + vehiculo,
                url: '<?=base_url()?>Cotizacion/gestionar',
                success: function(cotizacionID) {
                    //alertify.success(cotizacionID);
                    registrarDetalleCotizacion(cotizacionID);


                }
            });

        }
    }
    // registrar_series();


}




function agregar() {

    var productoCodigo = $("#txtproductoCodigo").val();
    var productoID = $("#txtProductoID").val();
    var cantidad = $("#txtCantidad").val();
    var um = $("#cboUM").val();
    var precio = $("#txtpuni").val();
    var subtotal = $("#txtSubtotal").val();
    var impuesto = $("#txtImpuesto").val();
    var importe = $("#txtImporte").val();
    var descripcion = $("#txtDescripcion").val();
    cont++;
    var fila = '<tr class="selected" id="fila' + cont + '" onclick="seleccionar(this.id)">' +
        '<td>' + cont + '</td>' +
        '<td><input type="text" value="' + productoCodigo +
        '" name="txtProductoCodigoT[]" class="txtProductoCodigoT" style="width: 100%" >' +
        '<input type="text" value="' + productoID +
        '" name="txtProductoIDT[]" class="txtProductoIDT" style="width: 100%"  hidden></td>' +
        '<td><input type="text" value="' + descripcion +
        '" name="txtDescripcionT[]" class="txtDescripcionT"  style="width: 100%"></td>' +
        '<td><input type="text" value="' + um + '" name="txtUmT[]" class="txtUmT"  style="width: 100%"></td>' +
        '<td><input type="text" value="' + cantidad +
        '" name="txtCantidadT[]" class="txtCantidadT"  style="width:100%"></td>' +
        '<td><input type="text" value="' + precio +
        '" name="txtPrecioT[]" class="txtPrecioT"  style="width: 100%"></td>' +
        '<td><input type="text" value="' + subtotal +
        '" name="txtSubtotalT[]" class="txtSubtotalT"   style="width: 100%"></td>' +
        '<td><input type="text" value="' + impuesto +
        '" name="txtImpuestoT[]" class="txtImpuestoT"  style="width: 100%" ></td>' +
        '<td><input type="text" value="' + importe +
        '" name="txtImporteT[]" class="txtImporteT" style="width: 100%"></td>' +
        '</tr>';
    $('#datos_tabla').append(fila);
    $("#modalAgregarProducto").modal("hide");

    reordenar();
    limpiar();
    return false;
}

function limpiar() {
    $("#txtproductoCodigo").val("");
    $("#txtProductoID").val("");
    $("#txtCantidad").val("");
    $("#cboUM").val("");
    $("#txtpuni").val("");
    $("#txtSubtotal").val("");
    $("#txtImpuesto").val("");
    $("#txtImporte").val("");
    $("#txtDescripcion").val("");
}

function seleccionar(id_fila) {
    if ($('#' + id_fila).hasClass('seleccionada')) {
        $('#' + id_fila).removeClass('seleccionada');
    } else {
        $('#' + id_fila).addClass('seleccionada');
    }
    //2702id_fila_selected=id_fila;
    id_fila_selected.push(id_fila);
}

function eliminar(id_fila) {
    /*$('#'+id_fila).remove();
    reordenar();*/
    for (var i = 0; i < id_fila.length; i++) {
        $('#' + id_fila[i]).remove();
    }
    reordenar();
}

function reordenar() {
    var num = 1;
    $('#datos_tabla tbody tr').each(function() {
        $(this).find('td').eq(0).text(num);
        num++;
    });
}

function eliminarTodasFilas() {
    $('#datos_tabla tbody tr').each(function() {
        $(this).remove();
    });

}



function calcularImporte() {
    var cantidad = $("#txtCantidad").val();
    var precio = $("#txtpuni").val();
    var subtotal = cantidad * precio;
    var impuestos = 0;

    $("#txtSubtotal").val(subtotal);

    impuesto = 18 / 100;
    impuestos = (subtotal * impuesto);
    $("#txtImpuesto").val(impuestos);
    var total = subtotal + impuestos;
    $("#txtImporte").val(total);
}

function cargarModalAgregar() {
    cargarUM();
    $("#modalAgregarProducto").modal("show");
}

function cargarUM() {
    $.ajax({
        url: "<?=base_url()?>Cotizacion/gestionar",
        type: "POST",
        data: "opcion=llenarUM",
        success: function(res) {
            $("#cargarUM").html(res);
        }
    })
}

function cargarcov() {
    $.ajax({
        url: "<?=base_url()?>Cotizacion/gestionar",
        type: "POST",
        data: "opcion=llenarCov",
        success: function(res) {
            $("#documento").html(res);
        }
    })
}

function buscarProducto(valor) {
    $.ajax({
        url: "<?=base_url()?>Cotizacion/gestionar",
        type: "POST",
        data: "opcion=buscarProducto" + "&codigo=" + valor,
        success: function(res) {
            $("#resCodigo").html(res);
        }
    })
}

function mostrarCliente(valor) {

    $.ajax({
        url: "<?=base_url()?>Cotizacion/gestionar",
        type: "POST",
        data: "opcion=mostrarCliente" + "&clienteID=" + valor,
        success: function(res) {
            $("#datosCliente").html(res);
        }
    })

}

$(document).ready(function() {

    $("#btnEliminarFila").click(function() {
        eliminar(id_fila_selected);
    });
    cargarsucursal();

    cargarVendedores();
    cargarcov();

})

function cargarsucursal() {

    $.ajax({
        url: "<?=base_url()?>Cotizacion/gestionar",
        type: "POST",
        data: "opcion=llenarSucursal",
        success: function(res) {
            $("#sucursal").html(res);
        }
    })

}

function cargarDocumento() {

    $.ajax({
        url: "<?=base_url()?>Cotizacion/gestionar",
        type: "POST",
        data: "opcion=llenarDocumento",
        success: function(res) {
            $("#documento").html(res);
        }
    })

}

function cargarVendedores() {

    $.ajax({
        url: "<?=base_url()?>Cotizacion/gestionar",
        type: "POST",
        data: "opcion=llenarAsesores",
        success: function(res) {
            $("#vendedores").html(res);
        }
    })

}
</script>
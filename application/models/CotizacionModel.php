<?php
/**
 * Created by PhpStorm.
 * User: Jhonathan Amaranto
 * Date: 26/02/2019
 * Time: 12:12
 */

class CotizacionModel extends CI_Model{

    function __construct()
    {
        parent::__construct();
    }

    public function gestionar($param){
        $this->param=$param;

        switch ($param["opcion"]){
            case "llenarSucursal":
                return $this->llenarSucursal();
                break;


            case "llenarDocumento":
                return $this->llenarDocumento();
                break;

            case "llenarAsesores":
                return $this->llenarAsesores();
                break;

            case "mostrarCliente":
                return $this->mostrarCliente();
                break;

            case "buscarProducto":
                return $this->buscarProducto();
                break;
            case "llenarUM":
                return $this->llenarUM();
                break;
            case "guardar_cotizacion":
                return $this->guardarCotizacion();
                break;
            case "registrar_detalleCotizacion":
                return $this->registrar_detalleCotizacion();
                break;
            case "cargar_tablaCotizacion":
                return $this->cargar_tablaCotizacion();
                break;

            case "cargar_tablaPlanificacion":
                return $this->cargar_tablaPlanificacion();
                break;

            case "cotizacion_aprobar":
                return $this->cotizacion_aprobar();
                break;
            case "cotizacion_pendiente":
                return $this->cotizacion_pendiente();
                break;
            case "actualizar_fechatrabajo":
                return $this->actualizar_fechaTrabajo();
                break;
            case "buscar_x_datos":
                return $this->buscar_x_datos();
                break;
            case "llenarCov":
                return $this->llenarCov();
                break;
            case "guardar_serie":
                return $this->guardar_serie();
                break;
        }

    }

    function guardar_serie(){
      $documento=$this->param["documento"];
      $numero=$this->param["nroDocumento"];
      $estado=$this->param["estado"];
      $serie=$this->param["serie"];
      var_dump($serie." ".$numero);
      $res=$this->db->query("insert into series(DOCUMENTO,SERIES,NUMERO,ESTADO)values ('".$documento."','".$serie."','".$numero."','".$estado."')");
      return $res;
    }

   private function buscar_x_datos(){
        if($this->param["serievh"]==''){
        $sql="select co.idCOTIZACION,s.DESCRIPCION as sucursal,co.SERIE as SERIEVH,c.RAZON_SOCIAL,a.DESCRIPCION,co.FECHA,co.ESTADO
         from cotizacion co inner join sucursal s on co.idSUCURSAL=s.idSUCURSAL
        inner join cliente c on c.idCLIENTE=co.idCLIENTE
        inner join asesores a on a.idASESORES=co.idASESORES
        where co.idASESORES=".$this->param["asesor"]." and
        co.idSUCURSAL=".$this->param["sucursal"]." and
        co.FECHA between '".$this->param["desde"]."' and '".$this->param["hasta"]."' 
        order by idCOTIZACION asc";
        }else{
            $sql="select co.idCOTIZACION,s.DESCRIPCION as sucursal,co.SERIE as SERIEVH,c.RAZON_SOCIAL,a.DESCRIPCION,co.FECHA,co.ESTADO
         from cotizacion co inner join sucursal s on co.idSUCURSAL=s.idSUCURSAL
        inner join cliente c on c.idCLIENTE=co.idCLIENTE
        inner join asesores a on a.idASESORES=co.idASESORES
        where co.idASESORES=".$this->param["asesor"]." and
        co.idSUCURSAL=".$this->param["sucursal"]." and
        co.SERIE='".$this->param["serievh"]."' and
        co.FECHA between '".$this->param["desde"]."' and '".$this->param["hasta"]."' 
        order by idCOTIZACION asc";
        }
        

        $respuesta=$this->db->query($sql);
        $data=json_encode($respuesta->result_array());
        $tabla=' <table id="datos_tabla" class="table table-striped table-bordered nowrap" style="width:100%" >
              <thead STYLE="background-color: lightgrey;color: white">
                <tr>
                    <th>#</th>
                    <th style="width: 100px">SUCURSAL</th>
                    <th style="width: 100px">SERIE</th>
                    <th style="width: 100px">CLIENTE</th>
                    <th style="width: 100px">VENDEDOR</th>
                    <th style="width: 100px">FECHA</th>
                    <th style="width: 100px"> ESTADO</th>
                    <th style="width: 100px">APROBAR</th>
                   

                </tr>
                </thead>
                <tbody>';

        $mdatos=json_decode($data);
       foreach ($mdatos as $itms) {
            $tabla.='<tr>';
            $tabla.='<td>'.$itms->idCOTIZACION.'</td>';
            $tabla.='<td>'.$itms->sucursal.'</td>';
            $tabla.='<td>'.$itms->SERIEVH.'</td>';
            $tabla.='<td>'.$itms->RAZON_SOCIAL.'</td>';
            $tabla.='<td>'.$itms->DESCRIPCION.'</td>';
            $tabla.='<td>'.$itms->FECHA.'</td>';
            if ($itms->ESTADO=="1") {
                $tabla.='<td>APROBADO</td>';
            }else{
                if ($itms->ESTADO=="2"){
                $tabla.='<td>PENDIENTE</td>';}
                if ($itms->ESTADO=="3"){
                $tabla.='<td>PLANIFICADO</td>';
            }
            }
           
          if ($itms->ESTADO=="1") {
                $tabla .= '<td id="' . $itms->idCOTIZACION . '" 
                onmousedown="activar(this.id,event,'.$itms->ESTADO.')"><input type="checkbox" id="' . $itms->idCOTIZACION . '" name="check" disabled checked></td>';
            }else{
                 if ($itms->ESTADO=="2") {
                $tabla .= '<td id="' . $itms->idCOTIZACION . '" onmousedown="activar(this.id,event,'.$itms->ESTADO.')">
                <input type="checkbox" id="' . $itms->idCOTIZACION . '" name="check" disabled></td>';
                 }
                 if ($itms->ESTADO=="3") {
                $tabla .= '<td id="' . $itms->idCOTIZACION . '" >
                <input type="checkbox" id="' . $itms->idCOTIZACION . '" name="check" disabled checked></td>';
                 }
                 
            }
      
            $tabla.='</tr>';
        }
        $tabla.='</tbody>
        </table>
        <script>
        var tabla= $("#datos_tabla").DataTable({
            scrollY: 400,
            responsive: true,
            language:{
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }

        })
        new $.fn.dataTable.FixedHeader( tabla );
        </script>   ';
        return $tabla;
    }

    function actualizar_fechaTrabajo(){
        $parametros=array(
            "FECHAPLANIFICACION"=>$this->param["fechaPlanificacion"]
        );
        $this->db->where("idCOTIZACION",$this->param["cotizacionID"]);
        $res=$this->db->update("cotizacion",$parametros);
        return $res;
    }

    function cotizacion_aprobar(){
       
        $this->db->where("idCOTIZACION",$this->param["cotizacionID"]);
        $res=$this->db->update("cotizacion",["ESTADO"=>"1"]);
        return $res;
    }
    function cotizacion_pendiente(){
    
        $this->db->where("idCOTIZACION",$this->param["cotizacionID"]);
        $res=$this->db->update("cotizacion",[ "ESTADO"=>"2"]);
        return $res;
    }

    private function cargar_tablaCotizacion(){
        $respuesta=$this->db->query('call sp_cotizacion_Mnt(
        0,0,"","",null,"1",1,
        1,1,null,null,null,null,null  )');

        $data=json_encode($respuesta->result_array());
        $tabla=' <table id="datos_tabla" class="table table-striped table-bordered nowrap" >
              <thead STYLE="background-color: lightgrey;color: white">
                <tr>
                    <th>#</th>
                    <th style="width: 100px">SUCURSAL</th>
                    <th style="width: 100px">SERIE</th>
                    <th style="width: 100px">CLIENTE</th>
                    <th style="width: 100px">VENDEDOR</th>
                    <th style="width: 100px">FECHA</th>
                    <th style="width: 100px"> ESTADO</th>
                    <th style="width: 100px">APROBAR</th>
                   

                </tr>
                </thead>
                <tbody>';

        $mdatos=json_decode($data);
        foreach ($mdatos as $itms) {
            $tabla.='<tr>';
            $tabla.='<td>'.$itms->idCOTIZACION.'</td>';
            $tabla.='<td>'.$itms->sucursal.'</td>';
            $tabla.='<td>'.$itms->SERIEVH.'</td>';
            $tabla.='<td>'.$itms->RAZON_SOCIAL.'</td>';
            $tabla.='<td>'.$itms->DESCRIPCION.'</td>';
            $tabla.='<td>'.$itms->FECHA.'</td>';
            if ($itms->ESTADO=="1") {
                $tabla.='<td>APROBADO</td>';
            }else{
                if ($itms->ESTADO=="2"){
                $tabla.='<td>PENDIENTE</td>';}
                if ($itms->ESTADO=="3"){
                $tabla.='<td>PLANIFICADO</td>';
            }
            }
           
          if ($itms->ESTADO=="1") {
                $tabla .= '<td id="' . $itms->idCOTIZACION . '" 
                onmousedown="activar(this.id,event,'.$itms->ESTADO.')"><input type="checkbox" id="' . $itms->idCOTIZACION . '" name="check" disabled checked></td>';
            }else{
                 if ($itms->ESTADO=="2") {
                $tabla .= '<td id="' . $itms->idCOTIZACION . '" onmousedown="activar(this.id,event,'.$itms->ESTADO.')">
                <input type="checkbox" id="' . $itms->idCOTIZACION . '" name="check" disabled></td>';
                 }
                 if ($itms->ESTADO=="3") {
                $tabla .= '<td id="' . $itms->idCOTIZACION . '" >
                <input type="checkbox" id="' . $itms->idCOTIZACION . '" name="check" disabled checked></td>';
                 }
                 
            }
      
            $tabla.='</tr>';
        }
        $tabla.='</tbody>
        </table>
            <script>
            var tabla= $("#datos_tabla").DataTable({
            scrollY: 400,
            responsive: true,
            language:{
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }

        })
        new $.fn.dataTable.FixedHeader( tabla );
        </script>   ';
        return $tabla;

    }

    private function registrar_detalleCotizacion(){
      
       for ($i=0;$i<count($this->param["productoID"]);$i++){
           $data[]=array(
               "item"=>(int)($i+1),
               "DESCRIPCION"=> $this->param["descripcion"][$i],
               "CANTIDAD"=>(int)$this->param["cantidad"][$i],
               "PRECIO"=> floatval($this->param["precio"][$i]),
               "SUBTOTAL"=> floatval($this-> param["subtotal"][$i]),
               "IMPUESTO"=>floatval($this-> param["impuesto"][$i]),
               "IMPORTE"=>floatval($this-> param["importe"][$i]),
               "idCOTIZACION"=>(int)$this->param["cotizacionID"][$i],
               "idPRODUCTOS"=>(int) $this->param["productoID"][$i]

       );


       }

       $res=$this->db->insert_batch('detalle_cotizacion', $data);
       return $res;
    }

    private function guardarCotizacion(){
        $respuesta=$this->db->query('call sp_cotizacion_Mnt(
        1,0,
        "'.$this->param["nroDocumento"].'",
        "'.$this->param["serievh"].'"
        ,"'.$this->param["fechaRegistro"].'",
        "'.$this->param["estado"].'"
        ,'.$this->param["clienteID"].',
        '.$this->param["asesor"].',
        '.$this->param["sucursal"].',
        null,
         "'.$this->param["fechaRegistro"].'",
         null,
        "null",
        "'.$this->param["documento"].'"  )');

        $data=json_encode($respuesta->result_array());
        $res="error en el servidor";
        $data=json_decode($data);
        foreach ($data as $item){
            $res=$item->insercionID;
        }
        echo $res;

    }

     private function buscarProducto(){
        $input="";
        $codigoProducto=$this->param["codigo"];
        if ($codigoProducto!=""){
            $this->db->where('ESTADO',1);
            $this->db->where('CODIGO',$codigoProducto);
            $cbo=$this->db->get("productos");
            $grupo=json_encode($cbo->result_array());
            $grupo=json_decode($grupo);




            foreach ($grupo as $item){
                $input.=' <input class="form-control " value="'.$item->DESCRIPCION.'" readonly name="txtDescripcion" id=txtDescripcion>
                <input type="text"  id="txtProductoID" name="txtProductoID" value="'.$item->idPRODUCTOS.'" hidden >
                '
                ;
            }
            if ($input==""){
                $input.=' <input class="form-control" value="producto no encontrado" readonly>';

            }

        }


        return $input;
    }

    private function llenarCov(){
        $idsucural=1;

        $cbo=$this->db->query("SELECT * FROM series where ESTADO=1 ORDER BY NUMERO DESC LIMIT 1;");
        $grupo=json_encode($cbo->result_array());
        $grupo=json_decode($grupo);



        $combo="<div class=\"col-sm-2\"  >DOCUMENTO";
        $combo.='
                <select id="cboCov" name="cboCov" class="form-control input-sm text-center" required>
               ';
        foreach ($grupo as $item){
            $combo.=' <option value="'.$item->DOCUMENTO.'">'.$item->DOCUMENTO.'</option>';
        }
        $combo.='</select></div>
        <div class="col-sm-3">
                NUMERO
                <input type="text" class="form-control input-sm " name="txtnumero" id="txtnumero" autocomplete="off" maxlength="7"
                required value="'.$item->NUMERO.'" readonly>
            </div>';

        return $combo;
    }

    private function llenarAsesores(){
        $idsucural=1;
        $this->db->where("idSUCURSAL",$idsucural);
        $this->db->where("Estado",1);
        $cbo=$this->db->get("asesores");
        $grupo=json_encode($cbo->result_array());
        $grupo=json_decode($grupo);



        $combo="";
        $combo.='
                <select id="cboAsesor" name="cboAsesor" class="form-control input-sm text-center" required>
               ';
        foreach ($grupo as $item){
            $combo.=' <option value="'.$item->idASESORES.'">'.$item->DESCRIPCION.'</option>';
        }
        $combo.='</select>';

        return $combo;
    }

    private function llenarUM(){



        $this->db->where("Estado",1);
        $cbo=$this->db->get("unidad_medida");
        $grupo=json_encode($cbo->result_array());
        $grupo=json_decode($grupo);



        $combo="";
        $combo.='
                <select id="cboUM" name="cboUM" class="form-control input-sm"  required>
                ';
        foreach ($grupo as $item){
            $combo.=' <option value="'.$item->idUM.'">'.$item->DESCRIPCION.'</option>';
        }
        $combo.='</select>';

        return $combo;
    }

   private function mostrarCliente(){
        $input="";
        $idCliente=$this->param["clienteID"];
        if ($idCliente!=""){
            $this->db->where('idCLIENTE',$idCliente);
            $cbo=$this->db->get("cliente");
            $grupo=json_encode($cbo->result_array());
            $grupo=json_decode($grupo);




            foreach ($grupo as $item){
                $input.=' <input class="form-control" value="'.$item->RAZON_SOCIAL.'" readonly>';
            }
            if ($input==""){
                $input.=' <input class="form-control" value="Cliente no encontrado" readonly>';
            }
        }


        return $input;
    }

    private function llenarSucursal(){
        $this->db->where("Estado",1);
      $cbo=$this->db->get("sucursal");
       $grupo=json_encode($cbo->result_array());
       $grupo=json_decode($grupo);

       $combo="";
        $combo.='
                <select id="cboSucursal" name="cboSucursal" class="form-control input-sm text-center" required>
                ';
                     foreach ($grupo as $item){
                         $combo.=' <option value="'.$item->idSUCURSAL.'">'.$item->DESCRIPCION.'</option>';
                    }
                $combo.='</select>';

       return $combo;
    }

   private function llenarDocumento(){
        $this->db->where("Estado",1);
        $cbo=$this->db->get("tipo_documento");
        $grupo=json_encode($cbo->result_array());
        $grupo=json_decode($grupo);



        $combo="";
        $combo.='
                <select id="cboDocumento" name="cboDocumento" class="form-control input-sm text-center" required>
               ';
        foreach ($grupo as $item){
            $combo.=' <option value="'.$item->idTIPO_DOCUMENTO.'">'.$item->DESCRIPCION.'</option>';
        }
        $combo.='</select>';

        return $combo;
    }




}
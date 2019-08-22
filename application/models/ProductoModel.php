<?php
/**
 * Created by PhpStorm.
 * User: Jhonathan Amaranto
 * Date: 26/02/2019
 * Time: 12:12
 */

class ProductoModel extends CI_Model{

    function __construct()
    {
        parent::__construct();
    }

    public function gestionar($param){
        $this->param=$param;

        switch ($param["opcion"]){
            case "llenarCombos":
                return $this->llenarCombos();
                break;

            case "llenarSubgrupos":
                return $this->llenarSubgrupos();
                break;
            case "obtener_productos":
                return $this->listarProductos();
                break;

            case "filtrarBusqueda":
                return $this->filtrar();
                break;

            case "desactivar":
                return $this->desactivar();
                break;
            case "activar":
                return $this->activar();
                break;
            case "llenarUM":
                return $this->llenarUM();
                break;
            case "editarProducto":
                return $this->editarProducto();
                break;

            case "verificarProducto":
                return $this->varificarProducto();
                break;
        }

    }

    public function varificarProducto($parametros){
        $descripcion=$parametros['descripcion'];
        $codigo=$parametros['codigo'];
            $data=$this->db->query("select *from productos where DESCRIPCION='".$descripcion."' or CODIGO='".$codigo."'" );
            $res=$data->num_rows();
            if ($res==0){
                return true;
            }else{
            return false;
            }

    }


   private function editarProducto(){
        $idProducto=$this->param['productoID'];
       $descripcion=$this->param['descripcion'];
       $codigo=$this->param["codigo"];



           $data=$this->db->query('update productos set CODIGO="'.$codigo.'",DESCRIPCION="'.$descripcion.'",
                                idGRUPO="'.$this->param['GrupoID'].'",idSUBGRUPO="'.$this->param['SubgrupoID'].'",
                                 idUM="'.$this->param['um'].'" where idPRODUCTOS="'.$idProducto.'"');

        return $data;
    }

    private function activar(){
        $idProducto=$this->param['productoID'];
        $parametro=array(
            'ESTADO'=>'1'
        );
        $this->db->where("idPRODUCTOS",$idProducto);
        $data=$this->db->update('productos',$parametro);

        return $data;
    }


    private function desactivar(){
        $idProducto=$this->param['productoID'];
        $parametro=array(
            'ESTADO'=>'0'
        );
        $this->db->where("idPRODUCTOS",$idProducto);
        $data=$this->db->update('productos',$parametro);

        return $data;
    }

    private function filtrar(){

        $grupo=$this->param["GrupoID"];
        $subgrupo=$this->param["SubgrupoID"];



        $data=json_encode($this->db->query('call SP_Mantenedor_Producto(1,'.$grupo.' ,'.$subgrupo.',0);')->result_array());

        $tabla=' 
 
        <table id="datos_tabla" class="table table-striped table-bordered nowrap" style="width:100%">
               
              <thead STYLE="background-color: lightgrey;color: white">
                <tr>
                    <th>CODIGO</th>
                    <th>DESCRIPCIÓN</th>
                    <th>GRUPO</th>
                    <th>SUBGRUPO</th>
                    <th>U.M.</th>
                    <th>OPCIONES</th>
                </tr>
                </thead>
                <tbody>';
        $mdatos=json_decode($data);
        foreach ($mdatos as $itms) {
            $tabla.='<tr>';
            $tabla.='<td>'.$itms->CODIGO.'</td>';
            $tabla.='<td>'.$itms->DESCRIPCION.'</td>';
            $tabla.='<td>'.$itms->GRUPO.'</td>';
            $tabla.='<td>'.$itms->SUBGRUPO.'</td>';
            $tabla.='<td>'.$itms->UM.'</td>';

             // if ($estado==1) {
            $tabla .= '<td><button  class="btn-xs btn-success" onclick="llenarDatos(' . $itms->CODIGO . ',`' . $itms->DESCRIPCION . '`)"><span class="glyphicon glyphicon-edit"></button>
                 <button class="btn-xs btn-danger" onclick="desactivar(' . $itms->CODIGO . ',`' . $itms->DESCRIPCION . '`)"><span class="glyphicon glyphicon-remove"></span></button></td>';
            //}else{
            //   $tabla .= '<td>';
             // $tabla.='<button class="btn-xs btn-primary" onclick="activar(' . $itms->idPRODUCTOS . ',`' . $itms->DESCRIPCION . '`)">
             //   <span class="glyphicon glyphicon-check"></span></button></td>';
             //}
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

    private function listarProductos(){
        $estado=$this->param["condicion"];
        $data=json_encode($this->db->query('call SP_Mantenedor_Producto(0,0,0,'.$estado.')')->result_array());

        $tabla=' <table id="datos_tabla" class="table table-striped table-bordered nowrap" style="width:100%">
              <thead STYLE="background-color: lightgrey;color: white">
                <tr>
                    <th>CODIGO</th>
                    <th>DESCRIPCIÓN</th>
                    <th>GRUPO</th>
                    <th>SUBGRUPO</th>
                    <th>U.M.</th>
                    <th>OPCIONES</th>
                </tr>
                </thead>
                <tbody>';
        $mdatos=json_decode($data);
        foreach ($mdatos as $itms) {
            $tabla.='<tr>';
            $tabla.='<td>'.$itms->CODIGO.'</td>';
            $tabla.='<td>'.$itms->DESCRIPCION.'</td>';
            $tabla.='<td>'.$itms->GRUPO.'</td>';
            $tabla.='<td>'.$itms->SUBGRUPO.'</td>';
            $tabla.='<td>'.$itms->UM.'</td>';

             if ($estado==1) {
            $tabla .= '<td><button  class="btn-xs btn-success" onclick="llenarDatos(' . $itms->idPRODUCTOS . ',`' . $itms->CODIGO . '`,`' . $itms->DESCRIPCION . '`)"><span class="glyphicon glyphicon-edit"></button>
                 <button class="btn-xs btn-danger" onclick="desactivar(' . $itms->idPRODUCTOS . ',`' . $itms->DESCRIPCION . '`)"><span class="glyphicon glyphicon-remove"></span></button></td>';
             }else{
              $tabla .= '<td>';
              $tabla.='<button class="btn-xs btn-primary" onclick="activar(' . $itms->idPRODUCTOS . ',`' . $itms->DESCRIPCION . '`)">
                <span class="glyphicon glyphicon-check"></span></button></td>';
             }
            $tabla.='</tr>';
        }
        $tabla.='</tbody>
<tfoot>
                <tr>
                    <th>CODIGO</th>
                    <th>DESCRIPCIÓN</th>
                    <th>GRUPO</th>
                    <th>SUBGRUPO</th>
                    <th>U.M.</th>
                    <th>OPCIONES</th>
                    
                </tr>
                </tfoot></table>
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
            },
            
            buttons: [
            {
                extend:    \'copyHtml5\',
                text:      \'<i class="fa fa-files-o"></i>\',
                titleAttr: \'Copy\'
            },
            {
                extend:    \'excelHtml5\',
                text:      \'<i class="fa fa-file-excel-o"></i>\',
                titleAttr: \'Excel\'
            },
            {
                extend:    \'csvHtml5\',
                text:      \'<i class="fa fa-file-text-o"></i>\',
                titleAttr: \'CSV\'
            },
            {
                extend:    \'pdfHtml5\',
                text:      \'<i class="fa fa-file-pdf-o"></i>\',
                titleAttr: \'PDF\'
            }
        ]

        })
        new $.fn.dataTable.FixedHeader( tabla );
</script>   ';
        return $tabla;

    }

    private function llenarCombos(){


        $this->db->where("Estado",1);
      $cbo=$this->db->get("grupo");
       $grupo=json_encode($cbo->result_array());
       $grupo=json_decode($grupo);



       $combo="";
        $combo.='
                <select id="cboGrupo" name="cboGrupo" class="form-control input-sm"  required>
              ';
                     foreach ($grupo as $item){
                         $combo.=' <option value="'.$item->idGRUPO.'">'.$item->DESCRIPCION.'</option>';
                    }
                $combo.='</select>';

       return $combo;
    }

    private function llenarSubgrupos(){


            $cbo = $this->db->query("select s.idSUBGRUPO as id,s.DESCRIPCION as des from subgrupo s inner join 
                            grupo g on g.idGRUPO=s.idGRUPO ");
            $grupo = json_encode($cbo->result_array());
            $grupo = json_decode($grupo);

            $combo = "";
            $combo .= '
                <select id="cboSubgrupo" class="form-control input-sm" name="cboSubgrupo" required>
              ';
            foreach ($grupo as $item) {
                $combo .= ' <option value="' . $item->id . '">' . $item->des . '</option>';
            }
            $combo .= '</select>';



        return $combo;
    }

    public function guardarProducto($data){
        $respuesta="";


       $rs=$this->db->query('insert into productos(CODIGO,DESCRIPCION,FOTO,ESTADO,idGRUPO,idSUBGRUPO,idUM) VALUES("'.$data['codigo'].'",
       "'.$data['descripcion'].'","'.$data['foto'].'","'.$data['estado'].'","'.$data['grupo'].'","'.$data['subgrupo'].'","'.$data['um'].'") ');
       if($rs){
           $respuesta="true";

       }
       else{
           $respuesta="false";
       }

       return $respuesta;
    }

    private function llenarUM(){

        $condicion=$this->param["condicion"];
        $locacion=$this->param["locacion"];



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
}
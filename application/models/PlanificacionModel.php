<?php
/**
 * Created by PhpStorm.
 * User: Jhonathan Amaranto
 * Date: 26/02/2019
 * Time: 12:12
 */

class PlanificacionModel extends CI_Model{

    function __construct()
    {
        parent::__construct();
    }

    public function gestionar($param){
        $this->param=$param;

        switch ($param["opcion"]){
           
            case "cargar_tablaPlanificacion":
                return $this->cargar_tablaPlanificacion();
                break;
            case "actualizar_fechaPlanificacion":
                return $this->actualizar_fecha_Planificacion();
                break;
            case "buscar_x_datos":
                return $this->buscar_x_datos();
                break;
        }

    }


   private function buscar_x_datos(){
        if($this->param["serievh"]==''){
            $sql='call sp_planificacion_Mnt(2,'.$this->param["asesor"].','.$this->param["sucursal"].',"",
            "'.$this->param["desde"].'","'.$this->param["hasta"].'")';
        }else{

            $sql='call sp_planificacion_Mnt(3,'.$this->param["asesor"].','.$this->param["sucursal"].',"'.$this->param["serievh"].'",
            "'.$this->param["desde"].'","'.$this->param["hasta"].'")';
     
        }  

        $respuesta=$this->db->query($sql);
        $data=json_encode($respuesta->result_array());
        $tabla=' <table id="datos_tabla" class="table table-striped table-bordered nowrap" style="width:100%" >
                <thead STYLE="background-color: lightgrey;color: white">
                <tr>
                    <th>#</th>
                    <th>SUCURSAL</th>
                    <th>SERIE</th>
                    <th>CLIENTE</th>
                    <th>VENDEDOR</th>
                    <th>FECHA</th>
                    <th>ESTADO</th>
                    <th>F.PLANIFICACION</th>
                    <th>PORCENTAJE</th>


                </tr>
                </thead>
                <tbody>';

        $mdatos=json_decode($data);
        foreach ($mdatos as $itms) {
            $tabla.='<tr>';
            $tabla.='<td >'.$itms->idCOTIZACION.'</td>';
            $tabla.='<td >'.$itms->sucursal.'</td>';
            $tabla.='<td>'.$itms->SERIEVH.'</td>';
            $tabla.='<td>'.$itms->RAZON_SOCIAL.'</td>';
            $tabla.='<td>'.$itms->DESCRIPCION.'</td>';
            $tabla.='<td>'.$itms->FECHA.'</td>';
             if ($itms->ESTADO=="1") {
                $tabla.='<td>APROBADO</td>';
            }else{
                if ($itms->ESTADO=="3"){
                $tabla.='<td>PLANIFICADO</td>';}
            }
         
            $tabla .= '<td id="' . $itms->idCOTIZACION . '" onmousedown="planificar(this.id,event)">' . $itms->FECHAPLANIFICACION . '</td>';
            $tabla.='<td >
            <div class="progress progress-sm active">
                <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar"
                aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: ' . round($itms->PORCENTAJE) . '%">
                  <span class="sr-only">' . round($itms->PORCENTAJE) . '% Completado</span>
                </div>
              </div>' . round($itms->PORCENTAJE) . '% Completado
            </td>';
            $tabla.='</tr>';
        }
        $tabla.='</tbody></table>
            <script>
            var tabla= $("#datos_tabla").DataTable({
            scrollY: 400,
           
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



    private function actualizar_fecha_Planificacion(){
        $parametros=array(
            "FECHAPLANIFICACION"=>$this->param["fechaPlanificacion"],
            "ESTADO"=>"3"
        );
        $this->db->where("idCOTIZACION",$this->param["cotizacionID"]);
        $res=$this->db->update("cotizacion",$parametros);
        return $res;
    }


    private function cargar_tablaPlanificacion(){
        $respuesta=$this->db->query('call sp_planificacion_Mnt(1,null,null,null,"2010-12-12","2010-12-12")');

        $data=json_encode($respuesta->result_array());
        $tabla=' <table id="datos_tabla" class="table table-striped table-bordered nowrap" style="width:100%">
              <thead STYLE="background-color: lightgrey;color: white">
                <tr>
                    <th>#</th>
                    <th>SUCURSAL</th>
                    <th>SERIE</th>
                    <th>CLIENTE</th>
                    <th>VENDEDOR</th>
                    <th>FECHA</th>
                    <th>ESTADO</th>
                    <th>F.PLANIFICACION</th>
                    <th>PORCENTAJE</th>


                </tr>
                </thead>
                <tbody>';

        $mdatos=json_decode($data);
        foreach ($mdatos as $itms) {
            $tabla.='<tr>';
            $tabla.='<td >'.$itms->idCOTIZACION.'</td>';
            $tabla.='<td >'.$itms->sucursal.'</td>';
            $tabla.='<td>'.$itms->SERIEVH.'</td>';
            $tabla.='<td>'.$itms->RAZON_SOCIAL.'</td>';
            $tabla.='<td>'.$itms->DESCRIPCION.'</td>';
            $tabla.='<td>'.$itms->FECHA.'</td>';
             if ($itms->ESTADO=="1") {
                $tabla.='<td>APROBADO</td>';
            }else{
                if ($itms->ESTADO=="3"){
                $tabla.='<td>PLANIFICADO</td>';}
            }
           
            $tabla .= '<td id="' . $itms->idCOTIZACION . '" onmousedown="planificar(this.id,event)">' . $itms->FECHAPLANIFICACION . '</td>';
            $tabla.='<td >
            <div class="progress progress-sm active">
                <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar"
                aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: ' . round($itms->PORCENTAJE) . '%">
                  <span class="sr-only">' . round($itms->PORCENTAJE) . '% Completado</span>
                </div>
              </div>' . round($itms->PORCENTAJE) . '% Completado
            </td>';


            $tabla.='</tr>';
        }
        $tabla.='</tbody>
         </table>
         <script>
            var tabla= $("#datos_tabla").DataTable({
            scrollY: 400,
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





}
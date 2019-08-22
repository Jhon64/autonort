<?php
class Vehiculo_ControladorModel extends CI_Model{
    
    public function __construct()
    {
        parent::__construct();
    }


    public function gestionar($param){
        $this->param=$param;
        switch($this->param["opcion"]){
            case "cargar_tablaPlanificacion":
                return $this->cargar_tablaPlanificacion();
                break;
            case "actualizar_fechaPlanificacion":
                return $this->actualizar_fecha_Planificacion();
                break;
            case "buscar_x_datos":
                return $this->buscar_x_datos();
                break;
            case "mostrar_cabecera":
                return $this->mostrar_cabecera();
                break;
            case "buscar_tecnicos":
                return $this->buscar_tecnicos();
                break;
            case "cargar_tecnicos":
                return $this->cargar_tecnicos();
                break;
            case "mostrar_cabecera_detener":
                return $this->mostrar_cabecera_detener();
                break;
            case "cargar_detalle_trabajo":
                return $this->cargar_detalle_trabajo();
                break;
        }
 

    }

    private function cargar_detalle_trabajo(){
        $this->db->select("*");
        $this->db->from("programacion p");
        $this->db->join("detalle_programacion dp","dp.idPROGRAMACION=p.idPROGRAMACION");
        $this->db->join("actividades a ","dp.idACTIVIDADES=a.idACTIVIDADES");
        $this->db->join("tecnicos t ","t.idTECNICOS=dp.idTECNICOS");
        $this->db->where("idCOTIZACION=2");
        $data=$this->db->get()->result_array();

        $tabla="";
        $cont=1;
        foreach ($data as $item){
            $tabla.="<tr>
            <th>".$cont."</th>
            <th>".$item["DESCRIPCION"]."</th>";
            $tabla.="<th>".$item["FECHAINICIO"]."</th>";
            $tabla.="<th>".$item["FECHAINICIO"]."</th>";
            $tabla.="<th>".$item["FECHAFINAL"]."</th>";
            $tabla.="<th>".$item["HORAFINAL"]."</th>";
            $tabla.="<th>".$item["NOMBRE"]."</th>";
            $tabla.="</tr>";
            $cont++;
        }
        return $tabla;
    }

    private function mostrar_cabecera_detener(){
        $this->db->select("SERIE,s.DESCRIPCION");
        $this->db->from("cotizacion c");
        $this->db->join("sucursal s","s.idSUCURSAL=c.idSUCURSAL");
        $this->db->where(" c.idCOTIZACION=1");
        $data=$this->db->get()->result_array();

        $respuesta=' <div class="row">
                <div class="col-xs-1 col-sm-1"></div>
                <div class="col-sm-4 col-xs-4">
                    <label>
                        SUCURSAL: &nbsp;<input type="text" value="'.$data[0]["DESCRIPCION"].'">
                    </label>
                </div>

                <div class="col-sm-4 col-xs-4">
                    <label>
                        SERIE VH: &nbsp;<input type="text" value="'.$data[0]["SERIE"].'" >
                    </label>
                </div>';
        return $respuesta;
    }

    public function registrar_programacion($tecnicos,$parametros){
        $this->db->trans_start();
        $fechaRegistro=date('Y-d-m H:i:s');
        $idProgramacion=$this->db->query("select count(*) as contador from programacion")->row_array();
        $id=$idProgramacion["contador"]+1;
        $arrayProgramacion=array(
            'idPROGRAMACION'=>$id,
            'idCOTIZACION'=>$parametros["cotizacionID"],
            'FECHAREGISTRO'=>$fechaRegistro
        );

       $this->db->insert('programacion',$arrayProgramacion);
       //$idProgramacion=$this->db->insert_id();
       $cadenaDetalleCotizacion="insert into detalle_programacion(idTECNICOS,FECHAINICIO,HORAINICIO,FECHAFINAL,HORAFINAL,idPROGRAMACION)";
       $cadenaDetalleCotizacion.="values";
       for($i=1;$i<count($tecnicos);$i++){
           $cadenaDetalleCotizacion.="(".$tecnicos[$i].",'".$parametros["fInicio"]."','".$parametros["hInicio"]."','".$parametros["fFin"]."',
           '".$parametros["hFin"]."',".$id."),";
       }

       $cadenaDetalleCotizacion=substr($cadenaDetalleCotizacion,0,strlen($cadenaDetalleCotizacion)-1);
       $res=$this->db->query($cadenaDetalleCotizacion);
        $this->db->trans_complete();
       if ($this->db->trans_status() === FALSE){
           $this->db->trans_rollback();
           return false;
       }else{
           //Todas las consultas se hicieron correctamente.
           $this->db->trans_commit();
           return true;
       }

    }

    private function mostrar_cabecera(){
        $respuesta=$this->db->query('call sp_vehiculo_controlador_Mnt(4,'.$this->param["cotizacionID"].')');
        $data=$respuesta->result_array();

        $tabla="";
        $tabla.="<div class='row'>
                    <div class='col-sm-4'>
                        <div class='form-group'>                
                            SUCURSAL
                            <input type='text' value='".$data[0]["sucursal"]."'>                     
                        </div>
                        <div class='form-group'>                
                            SERIE VH
                            <input type='text' value='".$data[0]["SERIEVH"]."'>                     
                        </div>
                    </div>
                    <div class='col-sm-8'>
                        <div class='form-group'>                
                            VENDEDOR
                            <input type='text' value='".$data[0]["DESCRIPCION"]."'>                     
                        </div>
                        <div class='form-group'>                
                            FECHA PLANIFICACIÓN
                            <input type='text' value='".$data[0]["FECHAPLANIFICACION"]."'>                     
                        </div>
                    </div>
                </div>";
        return $tabla;
    }
    private function cargar_tecnicos(){
        $this->db->join('cargo', 'tecnicos.idCARGO = cargo.idCARGO');
        $respuesta=$this->db->get('tecnicos');
        $data=$respuesta->result_array();
        
        $datos="";
        foreach($data as $row){ 
           $datos.='<tr id="'.$row["idTECNICOS"].'"> <td class="check"><input id="c'.$row["idTECNICOS"].'" type="checkbox"  onclick="seleccionar(this.id)" ></td>';
            $datos.='<td>'.$row["NOMBRE"].'</td>';
            $datos.='<td >'.$row["DESCRIPCION"].'</td></tr>';
        
        }
        return $datos;;
    }
    private function buscar_tecnicos(){
        $this->db->join('cargo', 'tecnicos.idCARGO = cargo.idCARGO');
        $this->db->like('NOMBRE',$this->param["valor"]);
        $respuesta=$this->db->get('tecnicos');
        $data=$respuesta->result_array();
        
        $datos="";
        foreach($data as $row){    
           $datos.='<tr id="'.$row["idTECNICOS"].'"> <td class="check"><input id="c'.$row["idTECNICOS"].'" type="checkbox"  onclick="seleccionar(this.id)" ></td>';
            $datos.='<td>'.$row["NOMBRE"].'</td>';
            $datos.='<td >'.$row["DESCRIPCION"].'</td></tr>';
        
        }
        return $datos;
    }

    private function buscar_x_datos(){
        if($this->param["serievh"]==''){
        $sql="select co.idCOTIZACION,s.DESCRIPCION as sucursal,co.SERIE as SERIEVH,c.RAZON_SOCIAL,a.DESCRIPCION,co.FECHA,co.ESTADO,
        co.FECHAPLANIFICACION, IF((datediff(CURDATE(),co.FECHA)/datediff(co.FECHAPLANIFICACION,co.FECHA))*100>100,100, datediff(CURDATE(),co.FECHA)/datediff(co.FECHAPLANIFICACION,co.FECHA)*100) as PORCENTAJE
        from cotizacion co inner join sucursal s on co.idSUCURSAL=s.idSUCURSAL
        inner join cliente c on c.idCLIENTE=co.idCLIENTE
        inner join asesores a on a.idASESORES=co.idASESORES
        where co.idASESORES=".$this->param["asesor"]." and
        co.idSUCURSAL=".$this->param["sucursal"]." and
        co.FECHA between '".$this->param["desde"]."' and '".$this->param["hasta"]."' and
         co.ESTADO='1' or co.ESTADO='3'
        order by idCOTIZACION asc ";
        }else{
           $sql="select co.idCOTIZACION,s.DESCRIPCION as sucursal,co.SERIE as SERIEVH,c.RAZON_SOCIAL,a.DESCRIPCION,co.FECHA,co.ESTADO,
        co.FECHAPLANIFICACION, IF((datediff(CURDATE(),co.FECHA)/datediff(co.FECHAPLANIFICACION,co.FECHA))*100>100,100, datediff(CURDATE(),co.FECHA)/datediff(co.FECHAPLANIFICACION,co.FECHA)*100) as PORCENTAJE
        from cotizacion co inner join sucursal s on co.idSUCURSAL=s.idSUCURSAL
        inner join cliente c on c.idCLIENTE=co.idCLIENTE
        inner join asesores a on a.idASESORES=co.idASESORES
        where co.idASESORES=".$this->param["asesor"]." and
        co.idSUCURSAL=".$this->param["sucursal"]." and
        co.SERIE='".$this->param["serievh"]."' and
        co.FECHA between '".$this->param["desde"]."' and '".$this->param["hasta"]."' and
        co.ESTADO='1' or co.ESTADO='3'
        order by idCOTIZACION asc ";
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
        $respuesta=$this->db->query('call sp_vehiculo_controlador_Mnt(1,0)');

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
                    <th>F.CULMINACION</th>
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
           
            $tabla .= '<td id="' . $itms->idCOTIZACION . '" >' . $itms->FECHAPLANIFICACION . '</td>';
            $tabla .= '<td id="' . $itms->idCOTIZACION . '" onmousedown="desplegar(this.id,event)">' . $itms->FECHACULMINACION . '</td>';
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
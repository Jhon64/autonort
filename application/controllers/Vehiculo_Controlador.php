<?php
/**
 * Created by PhpStorm.
 * User: Jhonathan Amaranto
 * Date: 12/02/2019
 * Time: 10:43
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Vehiculo_Controlador extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */

     public function __construct(){
         parent::__construct();
         $this->load->model('Vehiculo_ControladorModel');
     }
    public function index()
    {
        $this->load->view('layout/header');
        $this->load->view('layout/menu');
        $this->load->view('vehiculo_controlador/vehiculo');
        $this->load->view('layout/footer');

    }


    public function terminar()
    {
        $this->load->view('layout/header');
        $this->load->view('layout/menu');
        $this->load->view('vehiculo_controlador/terminar');
        $this->load->view('layout/footer');

    }
    public function programacion($CotizacionID = NULL)
    {
        $parametros= array('cotizacionID' =>$CotizacionID  );
        $this->load->view('layout/header');
        $this->load->view('layout/menu');
        $this->load->view('vehiculo_controlador/programar',$parametros);
        $this->load->view('layout/footer');

    }
    public function detener($CotizacionID = NULL)
    {
        $parametros= array('cotizacionID' =>$CotizacionID  );
        $this->load->view('layout/header');
        $this->load->view('layout/menu');
        $this->load->view('vehiculo_controlador/detener',$parametros);
        $this->load->view('layout/footer');

    }

    public function registrar_programacion(){
        date_default_timezone_set('America/Lima');
         $tecnicos=$_REQUEST["tecnicos"];
         $fFin=$_REQUEST["fFin"];
         $fInicio=$_REQUEST["fInicio"];
         $hInicio=$_REQUEST["HInicio"];
         $hFin=$_REQUEST["HFin"];
         $cotizacionID=$_REQUEST["cotizacionID"];
         $param=array(
           'fFin'=>$fFin,
           'fInicio'=>$fInicio,
           'hInicio'=>$hInicio,
           'hFin'=>$hFin,
           'cotizacionID'=>$cotizacionID
         );
        $data=$this->Vehiculo_ControladorModel->registrar_programacion($tecnicos,$param);
        echo $data;
    }

    public function gestionar()
    {
        $param=array();
        $param["nombre"]="";
        $param["opcion"]='mostrar_cabecera';
        $param["fechaPlanificacion"]='2019-04-21T21:00';
        $param["cotizacionID"]="1";
        $param["desde"]='2018-12-01';
        $param["hasta"]='2019-04-25';
        $param["serievh"]='';
        $param["asesor"]=1;
        $param["sucursal"]=1;
        $param["cotizacionID"]=1;
        $param["valor"]=1;

        if (isset($_POST["valor"])){
            $param["valor"]=$_POST["valor"];
        }
        if (isset($_POST["cotizacionID"])){
            $param["cotizacionID"]=$_POST["cotizacionID"];
        }
        if (isset($_POST["opcion"])){
            $param["opcion"]=$_POST["opcion"];
        }
        if (isset($_POST["fechaPlanificacion"])){
            $param["fechaPlanificacion"]=$_POST["fechaPlanificacion"];
        }
        if (isset($_POST["cotizacionID"])){
            $param["cotizacionID"]=$_POST["cotizacionID"];
        }

         if (isset($_POST["desde"])){
            $param["desde"]=$_POST["desde"];
        }

        if (isset($_POST["hasta"])){
            $param["hasta"]=$_POST["hasta"];
        }
         if (isset($_POST["asesor"])){
            $param["asesor"]=$_POST["asesor"];
        }

        if (isset($_POST["serievh"])){
            $param["serievh"]=$_POST["serievh"];
        }
        if (isset($_POST["sucursal"])){
            $param["sucursal"]=$_POST["sucursal"];
        }

        $data=$this->Vehiculo_ControladorModel->gestionar($param);
        echo $data;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Jhonathan Amaranto
 * Date: 8/02/2019
 * Time: 23:55
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Cotizacion extends CI_Controller {


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

    function __construct()
    {
        parent::__construct();
        $this->load->Model('CotizacionModel');
    }

    public function index()
    {
        $this->load->view('layout/header');
        $this->load->view('layout/menu');
        $this->load->view('Cotizacion/cotizacion');
        $this->load->view('layout/footer');

    }


    public function Exportar(){
         $this->load->view('layout/header');
        $this->load->view('layout/menu');
        $this->load->view('Cotizacion/Exportar'); 
         $this->load->view('layout/footer');

    }

    public function Nuevo()
    {
        $this->load->view('layout/header');
        $this->load->view('layout/menu');
        $this->load->view('Cotizacion/Nuevo');
        $this->load->view('layout/footer');

    }

    public function detalleCotizacion(){
        $aProductoID = array();
        $aDescripcion = array();
        $aUM = array();
        $aCantidad = array();
        $aPrecio = array();
        $aSubtotal = array();
        $aImpuesto = array();
        $aImporte = array();

        $param=array();
        $param["opcion"]='registrar_detalleCotizacion';
        $param["productoID"]='';
        $param["descripcion"]='';
        $param["um"]='';
        $param["cantidad"]='';
        $param["precio"]='';
        $param["subtotal"]='';
        $param["impuesto"]='';
        $param["importe"]='';
        $param["cotizacionID"]='';


        if (isset($_POST["opcion"])) {
            $param["opcion"] = $_POST["opcion"];
        }

        if (isset($_POST["productoID"])) {
            $param["productoID"] = explode(',',$_POST["productoID"]);
        }
        if (isset($_POST["descripcion"])) {
            $param["descripcion"] = explode(',',$_POST["descripcion"]);
        }
        if (isset($_POST["um"])) {
            $param["um"] = explode(',',$_POST["um"]);
        }
        if (isset($_POST["cantidad"])) {
            $param["cantidad"] = explode(',',$_POST["cantidad"]);
        }
        if (isset($_POST["precio"])) {
            $param["precio"] = explode(',',$_POST["precio"]);
        }
        if (isset($_POST["subtotal"])) {
            $param["subtotal"] = explode(',',$_POST["subtotal"]);
        }
        if (isset($_POST["impuesto"])) {
            $param["impuesto"] = explode(',',$_POST["impuesto"]);
        }
        if (isset($_POST["importe"])) {
            $param["importe"] = explode(',',$_POST["importe"]);
        }
        if (isset($_POST["cotizacionID"])) {
            $param["cotizacionID"] = explode(',',$_POST["cotizacionID"]);
        }


        $data=$this->CotizacionModel->gestionar($param);
        echo $data;

    }

    public function gestionar()
    {


        $param=array();
        $param["nombre"]="";
        $param["opcion"]='cotizacion_pendiente';
        $param["clienteID"]=0;
        $param["codigo"]='';
        $param["sucursal"]=0;
        $param["documento"]="";
        $param["nroDocumento"]="00002";
        $param["idDocumento"]='';
        $param["fechaRegistro"]= '';
        $param["clienteID"]=1;
        $param["descripcion"]='';
        $param["asesor"]=0;
        $param["serievh"]='';
        $param["estado"]='';
        $param["xorden"]='';
        $param["xserv"]='';
        $param["xreq"]='';
        $param["cotizacionID"]='1';
        $param["fechaPlanificacion"]='';
        $param["vehiculo"]='';
        $param["documento"]='COV';
        $param["desde"]='';
        $param["hasta"]='';
        $param["estado"]='1';
        $param["serie"]='0001';


        if (isset($_POST["serie"])){
            $param["serie"]=$_POST["serie"];
        }

        if (isset($_POST["estado"])){
            $param["estado"]=$_POST["estado"];
        }


        if (isset($_POST["desde"])){
            $param["desde"]=$_POST["desde"];
        }

        if (isset($_POST["hasta"])){
            $param["hasta"]=$_POST["hasta"];
        }

        if (isset($_POST["vehiculo"])){
            $param["vehiculo"]=$_POST["vehiculo"];
        }

        if (isset($_POST["vdocumento"])){
            $param["documento"]=$_POST["documento"];
        }

        if (isset($_POST["fechaPlanificacion"])){
            $param["fechaPlanificacion"]=$_POST["fechaPlanificacion"];
        }
        if (isset($_POST["cotizacionID"])){
            $param["cotizacionID"]=$_POST["cotizacionID"];
        }

        if (isset($_POST["xorden"])){
            $param["xorden"]=$_POST["xorden"];
        }
        if (isset($_POST["xserv"])){
            $param["xserv"]=$_POST["xserv"];
        }
        if (isset($_POST["xreq"])){
            $param["xreq"]=$_POST["xreq"];
        }

        if (isset($_POST["opcion"])){
            $param["opcion"]=$_POST["opcion"];
        }

        if (isset($_POST["clienteID"])){
            $param["clienteID"]=$_POST["clienteID"];
        }

        if (isset($_POST["codigo"])){
            $param["codigo"]=$_POST["codigo"];
        }

        if (isset($_POST["sucursal"])){
            $param["sucursal"]=$_POST["sucursal"];
        }

        if (isset($_POST["documento"])){
            $param["documento"]=$_POST["documento"];
        }

        if (isset($_POST["nroDocumento"])){
            $param["nroDocumento"]=$_POST["nroDocumento"];
        }

        if (isset($_POST["idDocumento"])){
            $param["idDocumento"]=$_POST["idDocumento"];
        }

        if (isset($_POST["fechaRegistro"])){
            $param["fechaRegistro"]=$_POST["fechaRegistro"];
        }

        if (isset($_POST["clienteID"])){
            $param["clienteID"]=$_POST["clienteID"];
        }

        if (isset($_POST["descripcion"])){
            $param["descripcion"]=$_POST["descripcion"];
        }

        if (isset($_POST["asesor"])){
            $param["asesor"]=$_POST["asesor"];
        }

        if (isset($_POST["serievh"])){
            $param["serievh"]=$_POST["serievh"];
        }

        if (isset($_POST["estado"])){
            $param["estado"]=$_POST["estado"];
        }


      //var_dump($param);
        $data=$this->CotizacionModel->gestionar($param);
       echo $data;

    }


}
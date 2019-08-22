<?php
/**
 * Created by PhpStorm.
 * User: Jhonathan Amaranto
 * Date: 8/02/2019
 * Time: 21:38
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Producto extends CI_Controller {

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
        $this->load->Model("ProductoModel");
    }

    public function index()
    {
        $this->load->view('layout/header');
        $this->load->view('layout/menu');
        $this->load->view('producto/producto');
        $this->load->view('layout/footer');
    }

    public function Nuevo()
    {
        $this->load->view('layout/header');
        $this->load->view('layout/menu');
        $this->load->view('producto/Nuevo');
        $this->load->view('layout/footer');


    }


    public function gestionar()
    {

        $param=array();
        $param["nombre"]="editarProducto";
        $param["opcion"]='editarProducto';
        $param["GrupoID"]='1';
        $param["SubgrupoID"]='1';
        $param["productoID"]='';
        $param["condicion"]='2';
        $param["locacion"]='';
        $param["categoria"]='';
        $param["codigo"]='657482';
        $param["um"]='1';
        $param["descripcion"]='PRUEBA EDICION FINAL 1';
        if (isset($_POST["opcion"])){
            $param["opcion"]=$_POST["opcion"];
        }

        if (isset($_POST["grupo"])){
            $param["GrupoID"]=$_POST["grupo"];
        }

        if (isset($_POST["subgrupo"])){
            $param["SubgrupoID"]=$_POST["subgrupo"];
        }

        if (isset($_POST["productoID"])){
            $param["productoID"]=$_POST["productoID"];
        }

        if (isset($_POST["condicion"])){
            $param["condicion"]=$_POST["condicion"];
        }

        if (isset($_POST["locacion"])){
            $param["locacion"]=$_POST["locacion"];
        }

        if (isset($_POST["um"])){
            $param["um"]=$_POST["um"];
        }

        if (isset($_POST["codigo"])){
            $param["codigo"]=$_POST["codigo"];
        }
        if (isset($_POST["descripcion"])){
            $param["descripcion"]=$_POST["descripcion"];
        }

        $data=$this->ProductoModel->gestionar($param);
        echo $data;

    }

    public function subirFoto()
    {

        if ($this->input->is_ajax_request()) {
            $grupo = $this->input->post("cboGrupo");
            $subgrupo = $this->input->post("cboSubgrupo");
            $codigo = $this->input->post("txtcodigo");
            $descripcion = $this->input->post("txtdescripcion");
            $estado = $this->input->post("cboEstado");
            $um = $this->input->post("cboUM");

            $datosverificar = array(
                "codigo" => $codigo,
                "descripcion" => $descripcion,
                "estado" => $estado

            );

            $dataVerifcar=$this->ProductoModel->varificarProducto($datosverificar);
            if ($dataVerifcar){
                $mi_archivo = 'imagen';
                $config['upload_path'] = "asset/imagenes/";
                $config['allowed_types'] = "jpg|png";
                $config['max_size'] = "50000";
                $config['max_width'] = "2000";
                $config['max_height'] = "2000";

                $this->load->library('upload', $config);

                if ($this->upload->do_upload($mi_archivo)) {
                    $data = array("upload_data" => $this->upload->data());
                    $datos = array(
                        "grupo" => $grupo,
                        "subgrupo" => $subgrupo,
                        "codigo" => $codigo,
                        "descripcion" => $descripcion,
                        "estado" => $estado,
                        "um" => $um,
                        "foto" => $data['upload_data']['file_name']
                    );

                    if ($this->ProductoModel->guardarProducto($datos) == true)
                        echo "exito";
                    else
                        echo "error";
                } else {
                    echo $this->upload->display_errors();
                }


            }else{
                echo "datos ya estan registrados";
            }

        }else{
        echo "error en el servidor";
        }

    }
}

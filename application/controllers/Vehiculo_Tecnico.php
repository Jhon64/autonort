<?php
/**
 * Created by PhpStorm.
 * User: Jhonathan Amaranto
 * Date: 12/02/2019
 * Time: 10:43
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Vehiculo_Tecnico extends CI_Controller {

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
    public function index()
    {
        $this->load->view('layout/header');
        $this->load->view('layout/menu');
        $this->load->view('vehiculo_tecnico/vehiculo');
        $this->load->view('layout/footer');

    }


    public function finalizar()
    {
        $this->load->view('layout/header');
        $this->load->view('layout/menu');
        $this->load->view('vehiculo_tecnico/finalizar');
        $this->load->view('layout/footer');

    }
    public function iniciar()
    {
        $this->load->view('layout/header');
        $this->load->view('layout/menu');
        $this->load->view('vehiculo_tecnico/iniciar');
        $this->load->view('layout/footer');

    }

}

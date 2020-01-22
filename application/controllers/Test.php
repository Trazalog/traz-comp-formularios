<?php defined('BASEPATH') or exit('No direct script access allowed');

class Test extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(FRM.'Forms');
    }

    public function index()
    {
        $data['frm'] = form($this->Forms->obtenerPlantilla(1));
        $this->load->view('test', $data);
        $this->load->view(FRM.'scripts');
    }
}

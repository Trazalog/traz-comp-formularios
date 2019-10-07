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
        $this->load->view('test1');
    }

    public function index1()
    {
        $data['frm'] = $this->Forms->html(3);
        $this->load->view('test', $data);
        $this->load->view(FRM.'scripts');
    }

    public function A()
    {
        echo 'A';
    }
    public function B()
    {
        echo 'B';
    }
    public function C()
    {
        echo 'C';
    }

    public function conexion()
    {
        return true;
    }
}

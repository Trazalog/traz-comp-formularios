<?php defined('BASEPATH') or exit('No direct script access allowed');

class Test extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Forms');
    }

    public function index()
    {
        $this->Forms->instanciarVariables(1,2);
        echo 'Hecho';
    }
}

<?php defined('BASEPATH') or exit('No direct script access allowed');

class Form extends CI_Controller
{
    public function __construct()
    {

        parent::__construct();
        $this->load->model('Forms');
    }
    public function index()
    {
        # $this->load->view('');
    }

    public function obtener()
    {
        $data['form'] = $this->Forms->obtener(1);
        $this->load->view('test', $data);
    }

    public function guardar()
    {
        $data = $this->input->post();

        foreach ($data as $key => $o) {
             
            $rsp = strpos($key, 'file');
            
            if($rsp > 0 )
            {
                $data[$key] = $this->uploadFile($key);
            }

        }

        echo json_encode(true);
    }

    public function uploadFile($nom)
    {
        $nom = str_replace("*file*", "", $nom);
            
        $conf = [
            'upload_path' => './files/',
            'allowed_types' => '*',
            'max_size'=>'*'
        ];

        $this->load->library("upload", $conf);

        if (!$this->upload->do_upload($nom)){

            log_message('DEBUG','Error al Subir el Archivo '.$nom);

            return false;

        }

        log_message('DEBUG','Archivo Subido con Existo'.$nom);

        return $this->upload->data()['file_name'];

    }
}

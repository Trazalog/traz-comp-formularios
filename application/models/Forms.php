<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Forms extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    // public function list()
    // {
    //     $this->db->select($this->columnas);
    //     $this->db->where('delete',false);
    //     return $this->db->get($this->tabla)->result_array();
    // }

    public function obtener($id)
    {
        $aux = new StdClass();
        $aux->nombre = $this->db->get('frm_formularios')->row()->nombre;
        $aux->id = $id;

        $this->db->from('frm_items as A');
        $this->db->join('frm_tipos_datos as B', 'B.tida_id = A.tida_id');
        $this->db->where('A.form_id', $id);
        $this->db->where('A.eliminado', false);
        $aux->plantilla = $this->db->get()->result();

        foreach ($aux->plantilla as $key => $o) {

            if($o->tipo == 'radio' || $o->tipo == 'check' || $o->tipo == 'select'){

                $aux->plantilla[$key]->values =  $this->obtenerValores($o->valo_id);

            }
        }

        return $aux;
    }

    public function obtenerValores($id)
    {
        $this->db->select('valor as value, valor as label');
        return $this->db->get_where('utl_tablas', array('tabla'=> $id))->result();
    }

    // public function insert($data)
    // {
    //     $this->db->insert($this->tabla,$data);
    //     return $this->db->insert_id();
    // }

    // public function update($data)
    // {
    //     $this->db->where($this->key,$data['id']);
    //     return $this->db->update($this->tabla,$data);
    // }

    // public function set_delete($id)
    // {
    //     $this->db->where($this->key,$id);
    //     $this->db->set('delete',true);
    //     return $this->db->update($this->tabla);
    // }

    // public function delete($id)
    // {
    //     $this->db->where($this->key,$id);
    //     return $this->db->delete($this->tabla);
    // }
}

<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Forms extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function guardar($form_id, $data)
    {
        $items = $this->obtenerItems($form_id);

        $newInfo = $this->db->select_max('info_id')->get('frm_instacias_formularios')->row('info_id') + 1;

        $array = array();

        foreach ($items as $o) {
            if (!$o->name) {
                continue;
            }

            $aux = new StdClass();

            if (is_array($data[$o->name])) {
                $aux->valor = implode('-', $data[$o->name]);
            } else {
                $aux->valor = $data[$o->name];
            }

            $aux->item_id = $o->item_id;

            $aux->info_id = $newInfo;

            array_push($array, $aux);
        }

        $this->db->insert_batch('frm_instacias_formularios', $array);

        return;
    }

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

            if ($o->tipo == 'radio' || $o->tipo == 'check' || $o->tipo == 'select') {

                $aux->plantilla[$key]->values = $this->obtenerValores($o->valo_id);

            }
        }

        return $aux;
    }

    public function obtenerItems($id)
    {
        $this->db->select('item_id, name');
        $this->db->where('form_id', $id);
        return $this->db->get('frm_items')->result();
    }

    public function obtenerValores($id)
    {
        $this->db->select('valor as value, valor as label');
        return $this->db->get_where('utl_tablas', array('tabla' => $id))->result();
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

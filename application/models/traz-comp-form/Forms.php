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
        $items = $this->obtenerPlantilla($form_id);

        $newInfo = $this->db->select_max('info_id')->get('frm_instancias_formularios')->row('info_id') + 1;

        $array = array();

        $aux = array();

        foreach ($items as $key => $o) {

            if ($o->name) {

                $o->valor = $data[$o->name];
                $o->info_id = $newInfo;
                array_push($array, $o);

            }else{
                
                $o->info_id = $newInfo;
                array_push($aux, $o);
            }
        }

        $this->db->insert_batch('frm_instancias_formularios', $array);
        $this->db->insert_batch('frm_instancias_formularios', $aux);

        return;
    }

    public function actualizar($form_id, $info_id, $data)
    {

        foreach ($data as $key => $o) {

            $this->db->where('form_id', $form_id);
            $this->db->where('info_id', $info_id);
            $this->db->where('name', $key);
            $this->db->set('valor', $o);
            $this->db->update('frm_instancias_formularios');
        }

        return;
    }

    public function obtener($id, $info_id = false)
    {
        $aux = new StdClass();
        $aux->nombre = $this->db->get('frm_formularios')->row()->nombre;
        $aux->id = $id;
        
        if ($info_id) {
            $aux->info_id = $info_id;

            $this->db->select('name, label, requerido, tida_id, valo_id, orden, form_id, aux, A.valor, B.valor as tipo');
            $this->db->from('frm_instancias_formularios as A');
            $this->db->where('A.info_id', $info_id);

        } else {
            $this->db->select('name, label, requerido, tida_id, valo_id, orden, form_id, aux, B.valor as tipo');
            $this->db->from('frm_items as A');
        }

        $this->db->join('utl_tablas as B', 'B.tabl_id = A.tida_id');
        $this->db->where('A.form_id', $id);
        $this->db->where('A.eliminado', false);
        $this->db->order_by('A.orden');

        #$query =  $this->db->get_compiled_select();

        $aux->items = $this->db->get()->result();

        foreach ($aux->items as $key => $o) {

            if ($o->tipo == 'radio' || $o->tipo == 'check' || $o->tipo == 'select') {

                $aux->items[$key]->values = $this->obtenerValores($o->valo_id);

            }
        }

        return $aux;
    }

    public function obtenerPlantilla($id)
    {
        $this->db->select('name, label, requerido, tida_id, valo_id, orden, form_id, aux');
        $this->db->where('form_id', $id);
        $this->db->where('eliminado', false);
        $this->db->order_by('orden');
        return $this->db->get('frm_items')->result();
    }

    public function obtenerValores($id)
    {
        $this->db->select('valor as value, valor as label');
        return $this->db->get_where('utl_tablas', array('tabla' => $id))->result();
    }

    public function listado()
    {
        $this->db->select('nombre, A.form_id, info_id');
        $this->db->from('frm_instancias_formularios as A');
        $this->db->join('frm_formularios as B', 'B.form_id = A.form_id');
        $this->db->group_by('A.form_id');
        return $this->db->get()->result();
    }
}

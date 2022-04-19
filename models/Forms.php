<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Forms extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }
    /**
        * Guarda la instacia del formulario dinámico
        * @param array datos de formulario
        * @return 
	*/
    public function guardar($form_id, $data = false)
    {   
        $items = $this->obtenerPlantilla($form_id);
        $array = array();
        $aux = array();
        
        foreach ($items->items as $key => $o) {

            unset($o->nombre);
            
            if ($o->name) {

                if(!is_array($data[$o->name]) && !is_array($_FILES["-file-".$o->name]['tmp_name'])){

                    $o->valor = $data[$o->name];
                    $o->valor4_base64 = null;
                    
                    
                    if($o->tipo_dato == 'image' || $o->tipo_dato == 'file'){
                        
                        $nom = "-file-".$o->name;
                        
                        if(!empty($_FILES[$nom]['tmp_name'])){
                            $o->valor4_base64 = base64_encode(file_get_contents($_FILES[$nom]['tmp_name']));
                        }
                    }
                    
                    array_push($array, $o);
                }else{
                    if(!empty($data[$o->name])){
                        foreach ($data[$o->name] as $i => $datos ) {
                            $datoPlantilla = clone $o;

                            $datoPlantilla->valor = $datos;
                            
                            $nom = "-file-".$datoPlantilla->name;
                            
                            if($datoPlantilla->tipo_dato == 'image' || $datoPlantilla->tipo_dato == 'file'){
            
                                if(!empty($_FILES[$nom]['tmp_name'][$i])){
                                    $datoPlantilla->valor4_base64 = base64_encode(file_get_contents($_FILES[$nom]['tmp_name'][$i]));
                                }else{
                                    $datoPlantilla->valor4_base64 = NULL;
                                }
                                
                            }else{
                                $datoPlantilla->valor4_base64 = NULL;
                            }

                            array_push($array, $datoPlantilla);
                            unset($datoPlantilla);
                        }

                        unset($o);
                    }else{
                        $o->valor = NULL;
                        $o->valor4_base64 = NULL;
                        array_push($array, $o);
                    }
                }
            } else {
                array_push($aux, $o);

                if(!empty($_FILES[$nom]['tmp_name'])){
                    $aux[$key]->valor4_base64 = base64_encode(file_get_contents($_FILES[$nom]['tmp_name']));
                }else{
                    $aux[$key]->valor4_base64 = NULL;
                }
            }
            unset($o);
        }

        if($aux && !$this->db->insert_batch('frm.instancias_formularios', $aux)) return FALSE;
        if($array && !$this->db->insert_batch('frm.instancias_formularios', $array)) return FALSE;
        
        $newInfo = $this->db->select_max('info_id')->get('frm.instancias_formularios')->row('info_id');

        $this->instanciarVariables($form_id, $newInfo);

        log_message('DEBUG',"#TRAZA | #TRAZ-COMP-FORMULARIOS | #FORMS | guardar() >> info_id generado ". $newInfo);

        return $newInfo;
    }

    public function actualizar($info_id, $data)
    {
        foreach ($data as $key => $o) {
            if(!$key) continue;
            $this->db->where('info_id', $info_id);
            $this->db->where('name', $key);
            $this->db->set('valor', $o);
            if(!empty($_FILES["-file-".$key]['tmp_name'])){
                $valor4_base64 = base64_encode(file_get_contents($_FILES["-file-".$key]['tmp_name']));
                $this->db->set('valor4_base64',$valor4_base64);
            }
            $this->db->update('frm.instancias_formularios');
        }
        log_message('DEBUG',"#TRAZA | #TRAZ-COMP-FORMULARIOS | #FORMS | actualizar() >> info_id actualizado: ". $info_id);
        return $info_id;
    }

    public function obtener($info_id)
    {
        $this->db->select('name, label,valor, requerido, valo_id, orden, A.inst_id, A.form_id, tipo_dato, C.nombre, A.valor4_base64, A.columna, A.multiple');
        $this->db->from('frm.instancias_formularios as A');
        $this->db->join('frm.formularios as C', 'C.form_id = A.form_id');
        $this->db->where('A.info_id', $info_id);
        $this->db->where('A.eliminado', false);
        $this->db->order_by('A.orden');

        $res = $this->db->get();

        $aux = new StdClass();
        $aux->info_id = $info_id;
        $aux->nombre = $res->row()->nombre;
        $aux->id = $info_id;
        $aux->items = $res->result();

        foreach ($aux->items as $key => $o) {

            if ($o->tipo_dato == 'radio' || $o->tipo_dato == 'check' || $o->tipo_dato == 'select') {

                $aux->items[$key]->values = $this->obtenerValores($o->valo_id);

            }
        }

        return $aux;
    }

    public function obtenerPlantilla($id)
    {
        $this->db->select('name, label, requerido, valo_id, orden, A.form_id, tipo_dato, C.nombre, A.columna, A.multiple');
        $this->db->from('frm.items as A');
        $this->db->join('frm.formularios as C', 'C.form_id = A.form_id');
        $this->db->where('A.form_id', $id);
        $this->db->where('A.eliminado', false);
        $this->db->order_by('A.orden');

        $res = $this->db->get();

        $newInfo = $this->db->select_max('info_id')->get('frm.instancias_formularios')->row('info_id') + 1;
        
        $aux = new StdClass();
        $aux->info_id = false;
        $aux->form_id = $id;
        $aux->nombre = $res->row()->nombre;
        $aux->id = $newInfo; 
        $aux->items = $res->result();

        foreach ($aux->items as $key => $o) {

            if ($o->tipo_dato == 'radio' || $o->tipo_dato == 'check' || $o->tipo_dato == 'select') {

                $aux->items[$key]->values = $this->obtenerValores($o->valo_id);

            }
        }

        return $aux;
    }

    /**
        * Obtengo los valores almacenados en core.tablas para cargar las listas de valores
        * @param id nombre columna tabla
        * @return array valores coincidentes
	*/
    public function obtenerValores($id){
        $this->db->select('tabl_id as value, descripcion as label,valor,eliminado');
        return $this->db->get_where('core.tablas', array('tabla' => empresa()."-".$id, 'eliminado' => 'false'))->result();
    }

    public function listado()
    {
        $this->db->select('B.nombre, A.form_id, A.info_id');
        $this->db->from('frm.instancias_formularios as A');
        $this->db->join('frm.formularios as B', 'B.form_id = A.form_id');
        $this->db->group_by('info_id, A.form_id, B.nombre');
        return $this->db->get()->result();
    }

    public function instanciarVariables($form_id, $info_id)
    {
        $this->db->select("name, variable, $info_id as info_id");
        $this->db->where('name is not null');
        $this->db->where('form_id', $form_id);
        $res = $this->db->get('frm.items')->result();
        
        foreach ($res as $o) {
            $this->db->where('info_id', $o->info_id);
            $this->db->where('name', $o->name);
            $this->db->set('variable', $o->variable);
            $this->db->update('frm.instancias_formularios');
        }
    }

    public function generarInstancia($form_id)
    {
        $res['info_id'] = $this->guardar($form_id);
        return $res;
    }

    public function validarVariable($info_id)
    {
        # code...
    }

    public function obtenerXEmpresa($nombre, $emprId)
    {
        $this->db->where('empr_id', $emprId);
        $this->db->where('nombre', $nombre);
        $res = $this->db->get('frm.formularios')->first_row();
        if($res){ 
            return $this->obtenerPlantilla($res->form_id);
        }
    }

    function listarFormularios()
    {
        log_message('DEBUG', 'Formularios/getFormularios');
        $resource = '/formularios/'.empresa();
        $url = REST_FRM . $resource;
        $array = $this->rest->callApi('GET', $url);
        return json_decode($array['data']);
    }
}

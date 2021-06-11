<?php defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('form')) {
    function form($data, $modal = false)
    {
        $html = "<form class='frm' id='frm-$data->id' data-ninfoid='$data->id' data-form='" . (isset($data->form_id) ? $data->form_id : 'frm-default') . "' data-info='" . (isset($data->info_id) ? $data->info_id : null) . "' data-valido='false'>";
        $html .= "<fieldset>";
        if (!$data->items) {
            return 'Formulario No encontrado.';
        }

        foreach ($data->items as $key => $e) {

            switch ($e->tipo_dato) {

                case 'titulo1':
                    $html .= "<h1>$e->label</h1>";
                    break;
                case 'titulo2':
                    $html .= "<h2>$e->label</h2>";
                    break;
                case 'titulo3':
                    $html .= "<h3>$e->label</h3>";
                    break;

                case 'comentario':
                    $html .= "<p class='text-info'>$e->label</p>";
                    break;

                case 'input':
                    $html .= input($e);
                    break;

                case 'select':
                    $html .= select($e);
                    break;

                case 'date':
                    $html .= datepicker($e);
                    break;

                case 'check':
                    $html .= check($e);
                    break;

                case 'radio':
                    $html .= radio($e);
                    break;

                case 'file':
                    $html .= archivo($e);
                    break;

                case 'textarea':
                    $html .= textarea($e);
                    break;
                
                case 'image':
                    $html .= image($e);
                    break;

                default:
                    $html .= "<hr>";
                    break;
            }
        }

        return $html . '<button type="button" class="btn btn-primary pull-right frm-save ' . ($modal ? 'hidden' : null) . '" onclick="frmGuardar(this)">Guardar</button></form></fieldset>';
    }
}
function input($e)
{
    return
        "<div class='".($e->columna ? $e->columna : 'col-md-12')."'>
            <div class='form-group'>
                <label for=''>$e->label" . ($e->requerido ? "<strong class='text-danger'> *</strong>" : null) . ":</label>
                <input class='form-control' value='" . (isset($e->valor) ? $e->valor : null) . "' type='text' placeholder='Escriba su $e->label...' id='$e->name'  name='$e->name' " . ($e->requerido ? req() : null) . "/>
            </div>
        </div>";
}

function select($e)
{
    $val = '<option value=""> -Seleccionar- </option>';
    foreach ($e->values as $o) {
        $val .= "<option value='$o->value' " . ((isset($e->valor) && $e->valor == $o->value) ? 'selected' : null) . ">$o->label</option>";
    }

    return
        "<div class='".($e->columna ? $e->columna : 'col-md-12')."'>
            <div class='form-group'>
                <label for=''>$e->label" . ($e->requerido ? "<strong class='text-danger'> *</strong>" : null) . ":</label>
                <select class='form-control frm-select' name='$e->name'>$val</select>
            </div>
        </div>";
}

function datepicker($e)
{
    return
        "<div class='".($e->columna ? $e->columna : 'col-md-12')."'>
            <div class='form-group'>
                <label for=''>$e->label" . ($e->requerido ? "<strong class='text-danger'> *</strong>" : null) . ":</label>
                <input class='form-control datepicker' value='" . (isset($e->valor) ? $e->valor : null) . "' type='date' placeholder='dd/mm/aaaa' id='$e->name'  name='$e->name' " . ($e->requerido ? req() : null) . " data-bv-date-format='DD/MM/YYYY' data-bv-date-message='Formato de Fecha Inválido'/>
            </div>
        </div>";

}

function check($e)
{
    $html = "";
    foreach ($e->values as $key => $o) {
        $html .= "<div class='checkbox'>
                                <label>
                                    <input type='checkbox' name='$e->name[]' class='flat-red i-check' value='$o->value' " . ($key == 0 && $e->requerido ? null : null) . ((isset($e->valor) && strpos("_" . $e->valor, $o->value) > 0 ? ' checked' : null)) . ">
                                    $o->label
                                </label>
                            </div>";
    }
    // $html .= "<input class='hidden' type='checkbox' name='$e->name[]' value=' ' checked>";
    return
        "<div class='".($e->columna ? $e->columna : 'col-md-12')."'>
            <div class='form-group'>
                <label>$e->label" . ($e->requerido ? "<strong class='text-danger'> *</strong>" : null) . ":</label><div style='margin-left: 10%;'> $html</div>
            </div>
        </div>";

}

function radio($e)
{
    $html = '';
    foreach ($e->values as $key => $o) {
        $html .= "<div class='radio'>
                        <label>
                            <input type='radio' name='$e->name' class='flat-red i-check' value='$o->value' " . ($key == 0 && $e->requerido ? null : null) . " " . ((isset($e->valor) && $e->valor == $o->value) ? 'checked' : null) . ">
                            $o->label
                        </label>
                    </div>";
    }
    return
        "<div class='".($e->columna ? $e->columna : 'col-md-12')."'>
            <div class='form-group'>
                <label>$e->label" . ($e->requerido ? "<strong class='text-danger'> *</strong>" : null) . ":</label><div style='margin-left: 10%;'> $html</div>
            </div>
        </div>";
}

function archivo($e)
{

    $file = null;

    if (isset($e->valor)) {
        // $url = base_url(files . $e->valor);
        $ext = obtenerExtension($e->valor);
        $rec = stream_get_contents($e->valor4_base64);
        $url = $ext.$rec;
        $file = " download='$e->valor' href='$url' ";
    } else {
        $file = "style='display: none;'";
    }

    return
        "<div class='".($e->columna ? $e->columna : 'col-md-12')."'>
            <div class='form-group'>
                <label>$e->label" . ($e->requerido ? "<strong class='text-danger'> *</strong>" : null) . ":</label>
                <input class='form-control' id='$e->name' type='file' name='-file-$e->name' " . ($e->requerido ? req() : null). ">
                <p class='help-block show-file'><a $file class='help-button col-sm-4 download' title='Descargar' download>
                    <iclass='fa fa-download'></i> Ver Adjunto</a>
                </p>
            </div>
        </div>";
}

function textarea($e)
{
    return
        "<div class='".($e->columna ? $e->columna : 'col-md-12')."'>
            <div class='form-group'>
                <label>$e->label</label>
                <textarea class='form-control' rows='3' placeholder='Ingrese Texto...' id='$e->name' type='file' name='$e->name' " . ($e->requerido ? req() : null)
        . ">" . (isset($e->valor) ? $e->valor : null) . "</textarea>
        </div>
    </div>";
}

function req()
{
    return
        ' data-bv-notempty
          data-bv-notempty-message="Campo Obligatorio *" ';
}

function hreq()
{
    echo '<strong class="text-danger">*</strong>';
}

function image($e){
    $style = '';
    if(isset($e->valor4_base64)){
    
        $rec = stream_get_contents($e->valor4_base64);
        $ext = obtenerExtension($e->valor);
        $style = "background-image: url($ext$rec);";
    }else{
        $style = "background-image: url(lib/imageForms/camera.png);";
    }
    
    return
    "<div class='".($e->columna ? $e->columna : 'col-md-12')."'>
        <label for='$e->label'>$e->label" . ($e->requerido ? "<strong class='text-danger'> *</strong>" : null) . ":</label>
        <div class='form-group imgConte'>
            <div class='imgEdit'>
                <input class='form-control' value='" . (isset($e->valor) ? $e->valor : null) . "' type='file' id='$e->name'  name='-file-$e->name' " . ($e->requerido ? req() : null) . " onchange='previewFile(this)' accept='image/*' capture/>
                <label for='$e->name'></label>
            </div>
        <div class='imgPreview'>
            <div id='vistaPrevia_$e->name' style='$style'></div>
        </div>
    </div>
    </div>";
}

function nuevoForm($form_id)
{
    if ($form_id) {
        $ci = &get_instance();
        $ci->load->model(FRM . 'Forms');
        $res = $ci->Forms->generarInstancia($form_id);
        $res = getForm($res['info_id']);
        return $res;
    }
}

function getForm($info_id)
{
    if ($info_id) {
        $ci = &get_instance();
        $ci->load->model(FRM . 'Forms');
        $res = $ci->Forms->obtener($info_id);
        $res = form($res);
        return $res;
    }
}

function getFormXEmpresa($nombre, $emprId){
        $ci = &get_instance();
        $ci->load->model(FRM . 'Forms');
        $res = $ci->Forms->obtenerXEmpresa($nombre, $emprId);
        return form($res);
}

//Funcion para obtener la extension del archivo codificado
function obtenerExtension($archivo){
    $ext = explode('.',$archivo);
        switch(strtolower($ext[1])){
            case 'jpg': $ext = 'data:image/jpg;base64,';break;
            case 'png': $ext = 'data:image/png;base64,';break;
            case 'jpeg': $ext = 'data:image/jpeg;base64,';break;
            case 'pjpeg': $ext = 'data:image/pjpeg;base64,';break;
            case 'wbmp': $ext = 'data:image/vnd.wap.wbmp;base64,';break;
            case 'webp': $ext = 'data:image/webp;base64,';break;
            case 'pdf': $ext = 'data:application/pdf;base64,';break;
            case 'doc': $ext = 'data:application/msword;base64,';break;
            case 'xls': $ext = 'data:application/vnd.ms-excel;base64,';break;
            case 'docx': $ext = 'data:application/vnd.openxmlformats-officedocument.wordprocessingml.document;base64,';break;
            case 'txt': $ext = 'data:text/plain;base64,';break;
            case 'csv': $ext = 'data:text/csv;base64,';break;
            default: $ext = "";
        }
    return $ext;
}
<?php defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('form')) {
    function form($data)
    {

        $html = "<form id='$data->id'>";

        foreach ($data->plantilla as $key => $e) {

            switch ($e->tipo) {

                case 'titulo':
                    $html .= "<h$e->tam>$e->label</h$e->tam>";
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

                default:
                    $html .= "<hr>";
                    break;
            }
        }

        return $html . '<button class="btn btn-primary pull-right save-form">Guardar</button></form>';
    }

    function input($e)
    {
        return
            "<div class='form-group'>
                <label for=''>$e->label" . ($e->requerido ? "<strong class='text-danger'> *</strong>" : null) . ":</label>
                <input class='form-control' type='text' placeholder='Escriba su Texto...' id='$e->name'  name='$e->name' " . ($e->requerido ? req() : null) . "/>
            </div>";
    }

    function select($e)
    {
        $val = '<option value=""> -Seleccionar- </option>';
        foreach ($e->values as $o) {
            $val .= "<option value='$o->value'>$o->label</option>";
        }

        return
            "<div class='form-group'>
            <label for=''>$e->label" . ($e->requerido ? "<strong class='text-danger'> *</strong>" : null) . ":</label>
            <select class='form-control' name='$e->name'>$val</select>
        </div>";
    }

    function datepicker($e)
    {
        return
            "<div class='form-group'>
                <label for=''>$e->label" . ($e->requerido ? "<strong class='text-danger'> *</strong>" : null) . ":</label>
                <input class='form-control datepicker' type='text' placeholder='dd/mm/aaaa' id='$e->name'  name='$e->name' " . ($e->requerido ? req() : null) . " data-bv-date-format='DD/MM/YYYY' data-bv-date-message='Formato de Fecha Inválido'/>
            </div>";

    }

    function check($e)
    {
        $html = '';
        foreach ($e->values as $key => $o) {
            $html .= "<div class='checkbox'>
                                <label>
                                    <input type='checkbox' name='$e->name[]' class='flat-red' value='$o->value' " . ($key == 0 && $e->requerido ? req() : null) . ">
                                    $o->label
                                </label>
                            </div>";
        }
        return
            "<div class='form-group'><label>$e->label" . ($e->requerido ? "<strong class='text-danger'> *</strong>" : null) . ":</label><div style='margin-left: 10%;'> $html</div></div>";

    }

    function radio($e)
    {   
        $html = '';
        foreach ($e->values as $key => $o) {
            $html .= "<div class='radio'>
                        <label>
                            <input type='radio' name='$e->name' class='flat-red' value='$o->value' ".($key == 0 && $e->requerido ? req() : null).">
                            $o->label
                        </label>
                    </div>";
        }
        return 
        "<div class='form-group'><label>$e->label" . ($e->requerido ? "<strong class='text-danger'> *</strong>" : null) . ":</label><div style='margin-left: 10%;'> $html</div></div>";
    }

    function archivo($e)
    {
        return
            "<div class='form-group'>
                  <label>$e->label" . ($e->requerido ? "<strong class='text-danger'> *</strong>" : null) . ":</label>
                  <input id='$e->name' type='file' name='$e->name' ".($e->requerido ? req() : null)
                  .">
                  <p class='help-block show-file' style='display: none;'><a class='help-button col-sm-4 download' title='Descargar' download><i
                    class='fa fa-download'></i> Ver Adjunto</a></p>
             </div>";
    }

}
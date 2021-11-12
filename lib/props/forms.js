
function frmValidar(id = false) {
    if (!id) {
        var btnForms = $('.btn-form').length;
        if (btnForms == 0) return true; //No hay forms

        var forms = $('#frm-list form');
        if (forms.length < btnForms) return false; //No se abrieron todos los Forms

        //Todos los Forms se abrieron y se verifica si todos fueron validados
        var ban = true;
        forms.each(function () {
            ban = ban && (this.dataset.valido == 'true');
        });

        if (!ban) console.log('FRM | Formularios No Válidos');

        return ban;
    } else {
        return $('#' + id).data('valido') == 'true';
    }
}

function initForm() {
    $('form').each(function () {
        $(this).bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                select: {
                    selector: '.frm-select',
                    validators: {
                        callback: {
                            message: 'Seleccionar Opción',
                            callback: function (value, validator, $field) {
                                if (value == '') {
                                    return false;
                                } else {
                                    return true;
                                }

                            }
                        }
                    }
                }
            }
        }).on('success.form.bv', function (e) {
            e.preventDefault();
        });
    });

    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy'
    });

    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass: 'iradio_flat-green'
    })

    $('input[type="file"]').on('change', function (e) {

        var filename = $(this).val();

        if (filename != "" && filename != null) {

            var link = $(this).closest('.form-group').find('a').show();
            var file = e.target.files[0];
            var filename = e.target.files[0].name;
            var blob = new Blob([file]);
            var url = URL.createObjectURL(blob);

            $(link).find('a').attr({
                'download': filename,
                'href': url
            });
        }
    });
}



function frmGuardar(e) {
    console.log('FRM | Guardando...');
    
    WaitingOpen();

    var form = $(e).closest('form').attr('id');
    var info = $(e).closest('form').data('info');
    
    var nuevo = (info == '');
    if (nuevo) info = $(e).closest('form').data('form');

    $('#' + form).bootstrapValidator('validate');

    var bv = $('#' + form).data('bootstrapValidator');

    $('#' + form).attr('data-valido', (bv.isValid() ? 'true' : 'false'));

    var formData = new FormData($('#' + form)[0]);

    //Preparo Informacion Checkboxs
    var checkbox = $('#' + form).find("input[type=checkbox]")
    $.each(checkbox, function (key, val) {
        if (!formData.has($(val).attr('name'))) {
            formData.append($(val).attr('name'), '');
        }
    });

    //Preparo Informacion Files
    var files = $('#' + form + ' input[type="file"]');
    files.each(function () {
        if (exist('conexion') && conexion()) {
            if (this.value != null && this.value != '') formData.append(this.name, this.value);
        } else {
            formData.delete(this.name);
        }
    });

    var json = formToJson(formData);

    if(exist('guardarEstado'))guardarEstado($('#task').val() + '_frm', json, '#' + form);

    if (exist('conexion') && !conexion()) {
        WaitingClose();

        console.log('Offline | Formulario Guardado...');

        $('#' + form).closest('.modal').modal('hide');

        ajax({
            type: 'POST',
            dataType: 'JSON',
            url: 'index.php/Form/guardarJson/' + info,
            data: {
                json
            },
            success: function (rsp) {

            },
            error: function (rsp) {

            }
        });

    } else {

        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            url: 'index.php/Form/guardar/' + info +(nuevo?'/true':''),
            data: formData,
            success: function (rsp) {

                $('#' + form).closest('.modal').modal('hide');
                
                if(exist('dgf'))dgf();

            },
            error: function (rsp) {

                alert('Error al Guardar Formulario');

            },
            complete: function () {
                WaitingClose();
            }
        });

    }
}

function detectarForm() {
    $('.frm-open').click(function () {

        if (isModalOpen()) return;

        obtenerForm(this.dataset.info, true, this.dataset.readonly == 'true');

    });

    $('.frm-new').click(function(){
        nuevoForm(this.dataset.form);
    });
}

function nuevoForm(form, show = true) {
    WaitingOpen();
    $.ajax({
        type: 'GET',
        dataType: 'JSON',
        url: 'index.php/Form/obtenerNuevo/' + form + '/' + modal,
        success: function (rsp) {
            if (modal) {
                $('#frm-list').append(rsp.html);

                if (show) $('#frm-modal-').modal('show');
                $('#frm-modal- .btn-accion').click(function () {
                    $(this).closest('.modal').find('.frm-save').click();
                });
            }

            initForm();
        },
        error: function (rsp) {

            console.log('Error al Obtener Formulario');

        },
        complete: function () {
            WaitingClose();
        }
    });
}


function obtenerForm(info, show = true, readonly = false) {
    WaitingOpen();
    $.ajax({
        type: 'GET',
        dataType: 'JSON',
        url: 'index.php/Form/obtener/' + info + '/' + modal,
        success: function (rsp) {
            if (modal) {
                $('#frm-modal-' + info).remove();
                $('#frm-list').append(rsp.html);

                if (exist('conexion') && !conexion()) {
                    console.log('Offiline | Sin Conexión...');

                    var task = $('#task').val();
                    var id = '#frm-' + info;
                    var aux = JSON.parse(sessionStorage.getItem(task + '_frm'));
                    if (aux != null) {

                        if (aux[id] != null) {

                            var form = JSON.parse(aux[id]);

                            console.log('Offline | Abriendo Estado Intermedio Formulario');

                            Object.keys(form).forEach(function (key) {

                                //Tipo Checks
                                if (key.includes('[]')) {

                                    $(id + ' [name="' + key + '"]').each(function () {

                                        this.checked = form[key].includes(this.value)

                                    });

                                } else {

                                    var input = $(id + ' [name="' + key + '"]')[0];

                                    //Radio
                                    // if (input.getAttribute('type') == 'radio' && input.value ==
                                    //     form[key]) {
                                    //     input.checked = true;
                                    //     return;
                                    // }

                                    if (input.tagName == 'TEXTAREA') {
                                       
                                        $(id + ' [name="' + key + '"]').html(form[key]);
                                    
                                    }else{
                                        
                                        if (input.getAttribute('type') != 'file') $(id + ' [name="' + key + '"]').val(form[key]);
                                    }

                                    //Default

                                }

                            });
                        }
                    }
                }

                if (show) $('#frm-modal-'+info).modal('show');

                $('#frm-modal-' + info + ' .btn-accion').click(function () {
                    $(this).closest('.modal').find('.frm-save').click();
                });
             
            }

            if(readonly) $('#frm-modal-' + info).find('fieldset').attr('disabled', true);else{
                $('#frm-modal-' + info).on("hidden.bs.modal", function () {
                    WaitingOpen();
                    $(this).find('.frm-save').click();
                });
            }

            initForm();
        },
        error: function (rsp) {

            console.log('Error al Obtener Formulario');
d
        },
        complete: function () {
            WaitingClose();
        }
    });
}

function nuevoForm(form, show = true){
    WaitingOpen();
    $.ajax({
        type: 'GET',
        dataType: 'JSON',
        url: 'index.php/Form/obtenerNuevo/' + form + '/' + modal,
        success: function (rsp) {
            if (modal) {
                $('#frm-list').append(rsp.html);

                if (show) $('#frm-modal-').modal('show');
                $('#frm-modal- .btn-accion').click(function () {
                    $(this).closest('.modal').find('.frm-save').click();
                });
            }

            initForm();
        },
        error: function (rsp) {

            console.log('Error al Obtener Formulario');

        },
        complete: function () {
            WaitingClose();
        }
    });
}

function formToJson(formData) {

    var object = {};

    formData.forEach((value, key) => {

        if (!object.hasOwnProperty(key)) {
            object[key] = value;
            return;
        }

        if (!Array.isArray(object[key])) {
            object[key] = [object[key]];
        }

        object[key].push(value);

    });

    return JSON.stringify(object);
}

function exist(nombre) {
    var fn = window[nombre];
    return typeof fn === 'function';
}

function showFD(formData) {
    for (var pair of formData.entries()) {
        console.log(pair[0] + ', ' + pair[1]);
    }
}

function formToObject(formData) {
    return JSON.parse(formToJson(formData));
}


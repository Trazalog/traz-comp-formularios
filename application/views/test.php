<input id="frm-id" type="text">
<div class="row">
    <div class="col-sm-6">
        <div class="box box-primary">
            <div class="box-body">
                <div class="form-group">
                    <label for="">Nombre Formulario:</label>
                    <input id="nombre" type="text" class="form-control" placeholder="Ingrese Texto">
                </div>
                <button class="btn btn-primary pull-right" onclick="nuevoForm()">Crear</button>
            </div>
        </div>
        <div class="box box-primary">
            <div class="box-body">
                <?php 
                    echo $frm;
                ?>
                <button class='btn btn-primary pull-right' onclick='add()'>Agregar Item</button>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="box box-primary">
            <div class="box-body">
                <div id="frm"></div>
            </div>
        </div>
    </div>
</div>

<script>
$('.frm-save').hide();

function nuevoForm() {
    var nombre = $('#nombre').val();
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: 'index.php/<?php echo FRM ?>Form/crear',
        data: {
            nombre
        },
        success: function(result) {
            $('#frm-id').val(result.id);
        },
        error: function(result) {
            alert('Error');
        }
    });
}

function add() {

    var form = $('#frm-id').val();
    if (form == null || form == '') return;

    var formData = new FormData($('form')[0]);
    formData.append('form_id', form);

    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: 'index.php/<?php echo FRM ?>Form/agregarItem',
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        success: function(result) {
            $('#frm').html(result.html);
        },
        error: function(result) {
            alert('Error');
        }
    });
}

$('input[type="radio"]').on('change', function() {

    var form = '#frm-1';

    var input = $(form + ' input[name="name"]').parent();

    var opc = $(form + ' input[name="opciones"]').parent();

    var req = $(form + ' input[name="requerido[]"]').closest('.form-group');

    req.show();
    input.show();
    opc.hide();

    switch (this.value) {
        case 'titulo1':
            input.hide();
            req.hide();
            break;
        case 'titulo2':
            input.hide();
            req.hide();
            break;
        case 'titulo3':
            input.hide();
            req.hide();
            break;
        case 'comentario':
            input.hide();
            req.hide();
            break;
        case 'select':
            opc.show();
            break;
        case 'radio':
            opc.show();
            break;
        case 'check':
            opc.show();
            break;

        default:
            break;
    }
});
</script>
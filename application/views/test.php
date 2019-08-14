<?php
$forms = getJson('form_test')->test;
?>

<div class="row">
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header">
                <i class="ion ion-clipboard"></i>
                <h3 class="box-title"><?php echo $forms[0]->nombre ?></h2>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="" data-original-title="Collapse">
                            <i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                            title="" data-original-title="Remove">
                            <i class="fa fa-times"></i></button>
                    </div>
            </div>
            <div class="box-body">
                <?php

                echo form($forms[0]);

                ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">

        <div class="box box-primary">
            <div class="box-header">
                <i class="ion ion-clipboard"></i>
                <h3 class="box-title"><?php echo $forms[1]->nombre ?></h2>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="" data-original-title="Collapse">
                            <i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                            title="" data-original-title="Remove">
                            <i class="fa fa-times"></i></button>
                    </div>
            </div>
            <div class="box-body">
                <?php

                echo form($forms[1]);

                ?>
            </div>
        </div>
    </div>
</div>

<script>
$('form').each(function() {
    $(this).bootstrapValidator({
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            select: {
                selector: '#' + $(this).attr('id') + ' select',
                validators: {
                    callback: {
                        message: 'Seleccionar Opción',
                        callback: function(value, validator, $field) {
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
    }).on('success.form.bv', function(e) {
        e.preventDefault();
    });
});

$('.datepicker').datepicker({
    dateFormat: 'DD-MM-YYYY'
});

$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
    checkboxClass: 'icheckbox_flat-green',
    radioClass: 'iradio_flat-green'
}).on('ifChanged', function(e) {
                // Get the field name
    var field = $(this).attr('name');
    $(this).closest('form').bootstrapValidator('revalidateField', field);
});

$('input[type="file"]').on('change', function(e) {

    var filename = $(this).val();

    if (filename != "" && filename != null) {

        var link = $(this).closest('.form-group').find('p').show();
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

$('.save-form').click(function(e) {

    e.preventDefault();

    $('#' + $(this).closest('form').attr('id')).bootstrapValidator('validate');

});
</script>
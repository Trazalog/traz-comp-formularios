<!-- jQuery 3 -->
<script src="<?php base_url()?>lib/bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php base_url()?>lib/bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
$.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php base_url()?>lib/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- jQuery Knob Chart -->
<script src="<?php base_url()?>lib/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php base_url()?>lib/bower_components/moment/min/moment.min.js"></script>

<script src="<?php base_url()?>lib/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?php base_url()?>lib/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js">
</script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php base_url()?>lib/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="<?php base_url()?>lib/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php base_url()?>lib/bower_components/fastclick/lib/fastclick.js"></script>

<script src="<?php base_url()?>lib/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>

<script src="<?php base_url()?>lib/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<!-- AdminLTE App -->
<script src="<?php base_url()?>lib/dist/js/adminlte.min.js"></script>

<script src="<?php base_url();?>lib/plugins/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>

<!-- iCheck 1.0.1 -->
<script src="<?php base_url();?>lib/plugins/iCheck/icheck.min.js"></script>

<script src="<?php echo base_url(); ?>lib/bootstrapValidator/bootstrapValidator.min.js"></script>

<?php $this->load->view('layout/sw')?>


<script src="<?php echo base_url() ?>lib/props/gps.js"></script>
<script src="<?php echo base_url() ?>lib/props/offline.js"></script>

<?php  $this->load->view(FRM.'scripts') ?>
<script>
function conexion() {
    return true;
}

Offline.options = {
    checks: {
        xhr: {
            url: '<?php echo base_url() ?>index.php/Test/conexion'
        }
    }
};

//OFFLINE SETTING
Offline.on('up', function() {
    $('#conexion').removeClass('text-danger').addClass('text-green');
});

Offline.on('down', function() {
    $('#conexion').removeClass('text-green').addClass('text-danger');
});

var run = function() {
    if (Offline.state === 'up')
    Offline.check();
}
//setInterval(run, 5000);
</script>
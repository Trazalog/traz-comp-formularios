       <!-- jQuery 3 -->
       <script src="<?php base_url() ?>lib/bower_components/jquery/dist/jquery.min.js"></script>
       <!-- jQuery UI 1.11.4 -->
       <script src="<?php base_url() ?>lib/bower_components/jquery-ui/jquery-ui.min.js"></script>
       <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
       <script>
$.widget.bridge('uibutton', $.ui.button);
       </script>
       <!-- Bootstrap 3.3.7 -->
       <script src="<?php base_url() ?>lib/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

       <!-- jQuery Knob Chart -->
       <script src="<?php base_url() ?>lib/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
       <!-- daterangepicker -->
       <script src="<?php base_url() ?>lib/bower_components/moment/min/moment.min.js"></script>

       <script src="<?php base_url() ?>lib/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
       <!-- datepicker -->
       <script src="<?php base_url() ?>lib/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js">
       </script>
       <!-- Bootstrap WYSIHTML5 -->
       <script src="<?php base_url() ?>lib/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
       <!-- Slimscroll -->
       <script src="<?php base_url() ?>lib/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
       <!-- FastClick -->
       <script src="<?php base_url() ?>lib/bower_components/fastclick/lib/fastclick.js"></script>

       <script src="<?php base_url() ?>lib/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>

       <script src="<?php base_url() ?>lib/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

       <!-- AdminLTE App -->
       <script src="<?php base_url() ?>lib/dist/js/adminlte.min.js"></script>

       <script src="<?php base_url();?>lib/plugins/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>

       <!-- iCheck 1.0.1 -->
       <script src="<?php base_url();?>lib/plugins/iCheck/icheck.min.js"></script>

       <script src="<?php  echo base_url();?>lib/bootstrapValidator/bootstrapValidator.min.js"></script>

       <script>
jQuery.fn.single_double_click = function(single_click_callback, double_click_callback, timeout) {
        return this.each(function() {
            var clicks = 0,
                self = this;
            jQuery(this).click(function(event) {
                clicks++;
                if (clicks == 1) {
                    setTimeout(function() {
                        if (clicks == 1) {
                            single_click_callback.call(self, event);
                        } else {
                            double_click_callback.call(self, event);
                        }
                        clicks = 0;
                    }, timeout || 300);
                }
            });
        });
    }


    <?php if(SW) {?>
    console.log('SW | Service Worker Activado');

    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('sw1.js').then(function() {
                console.log('SW | Service Worker Registrado');
                if (!navigator.serviceWorker.controller) {
                    location.reload();
                }
            })
        });
    } <?php } ?>
       </script>

       <script src="<?php echo base_url() ?>lib/props/gps.js"></script>
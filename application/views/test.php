<button onclick="initForm()">FRM INIT</button>
<div class="box">
    <div class="box-body">
        <div class="frm-new" data-id="1"></div>
    </div>
</div>

<script>
$('.frm-new').each(function() {
    $(this).load('<?php echo base_url() ?>Form/obtenerNuevo/' + this.dataset.id);
});
</script>
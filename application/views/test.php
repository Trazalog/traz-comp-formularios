<div class="box">
    <div class="box-body">
        <?php 
    echo $frm;
?>
    </div>
</div>
<button class="btn btn-primary" onclick="check()">Check</button>

<script>
function check(){
    if (!window.mobileAndTabletcheck()) {console.log('GPS | No Mobile'); return;}

    if(obtenerPosicion()) alert('LAT: ' + lat + ' - LON: ' + lon + ' - ACC: ' + ac);
    else alert('GPS | No se pudo Obtener Ubicación, Por favor Activar el GPS del Dispositivo.');
    //alert('Para Ejecutar la Orden de Trabajo debe, Encender el GSP.');
}
</script>
<div class="box">
    <div class="box-body">
        <?php 
    echo $frm;
?>
    </div>
</div>
<button class="btn btn-primary" onclick="check()">Check</button>


<script>
function check() {
    if (window.mobileAndTabletcheck()) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(success, error, options);
        } else {
            alert('GSP no Activado');
        }
    }
}

var options = {
    enableHighAccuracy: true,
    timeout: 5000,
    maximumAge: 0
};

var lat = false;
var lon = false;
function success(pos) {
    var crd = pos.coords;
    alert('Lati : ' + crd.latitude + '- Long: ' + crd.longitude + ' Aprox: ' + crd.accuracy);
    if((cdr.accuracy != null) || (cdr.acurrary < 50)){
        console.log('More or less ' + crd.accuracy + ' meters.');
        lat = crd.latitude;
        lon = crd.longitude;
    }else{
        alert('Para Ejecutar la Orden de Trabajo debe, Encender el GSP.');
        lat = false;
        lon = false;
    }
};

function error(err) {
    alert('Para Ejecutar la Orden de Trabajo debe, Encender el GSP.');
    console.log('ERROR(' + err.code + '): ' + err.message);
};
</script>
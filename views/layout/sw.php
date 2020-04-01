<script>
<?php
if(SW) { ?>
    //make sure that Service Workers are supported.
    if (navigator.serviceWorker) {
        navigator.serviceWorker.register('<?php echo SW ?>')
            .then(function(registration) {
                console.log(registration);
                if (!navigator.serviceWorker.controller) {
                    location.reload();
                }
            })
            .catch(function(e) {
                console.error(e);
            })
    } else {
        console.log('Service Worker is not supported in this browser.');
    }




//Precacheo
base_url = "<?php echo base_url() ?>index.php/";
if (!indexedDB) {
    alert("Este browser no soporta IndexedDB, necesita otro para poder utilizar la aplicación.");
}

indexedDB.open('tcf-ajax').onupgradeneeded = function(event) {
    event.target.result.createObjectStore('ajax_requests', {
        autoIncrement: true,
        keyPath: 'id'
    });
}

var catch_url = [
      base_url + 'Test/A',
      base_url + 'Test/B',
      base_url + 'Test/C',
]

 caches.open('tcf-cache').then(function(cache) {
     return cache.addAll(catch_url);
 });<?php } ?>
</script>
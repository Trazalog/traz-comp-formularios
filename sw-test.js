importScripts('https://storage.googleapis.com/workbox-cdn/releases/4.3.1/workbox-sw.js'); workbox.loadModule('workbox-strategies');
var messageData = "";
var cacheName = 'traz-comp-form';
var base_url = 'https://192.168.0.101/traz-comp-formularios/';
const NF = new workbox.strategies.NetworkFirst({
    cacheName: cacheName + '-cache'
});

workbox.precaching.precacheAndRoute([
    { url: base_url + 'index.php', revision: 'abc123' }
]);

self.addEventListener('fetch', function (event) {
    if (event.request.clone().method === 'POST') {
        event.respondWith(
            fetch(event.request.clone()).catch(function (error) {
                storePostRequest(event.request.clone().url, messageData);
                return new Responce();
            })
        );
    } else {

       if ( event.request.url == base_url + 'index.php/Test/conexion') return false;
        event.respondWith(
            NF.handle(event).then((response) => {
                fetch(event.request).then(function (response1) {
                    let responseClone = response.clone();
                    caches.open(cacheName + '-cache').then(function (cache) {
                        cache.put(event.request, responseClone);
                    });

                    return response || caches.match(event.request);
                }).catch(function () {
                    return caches.match(event.request).then(function (response) {
                        if (response) {
                            console.log('GET Reply from Cache for URL:', event.request.clone().url);
                            return response;
                        }

                        return new Response('', {
                            headers: { 'Content-Type': 'text/html' }
                        });
                    });

                })
                return response || caches.match(event.request);
            })
        );
    }
});



self.addEventListener('message', function (event) {
    if (event.data === 'processQueue') {
        event.waitUntil(processQueue())
    } else {
        messageData = event.data;
    }
});

function processQueue() {
    indexedDB.open(cacheName + '-ajax').onsuccess = function (event) {
        var savedRequests = []
        event.target.result.transaction('ajax_requests', 'readonly').objectStore('ajax_requests').openCursor().onsuccess = async function (openCursorEvent) {
            var cursor = openCursorEvent.target.result

            if (cursor) {
                savedRequests.push(cursor.value)
                cursor.continue()
            } else {
                for (let savedRequest of savedRequests) {
                    var requestUrl = savedRequest.url
                    var payload = Object.keys(savedRequest.payload).map(key => key + '=' + savedRequest.payload[key]).join('&');
                    var method = savedRequest.method
                    var headers = {
                        'Accept': 'application/json',
                        'Content-Type': 'application/x-www-form-urlencoded',
                    }

                    fetch(requestUrl, {
                        headers: headers,
                        method: method,
                        body: payload
                    }).then(function (response) {
                        event.target.result.transaction('ajax_requests', 'readwrite').objectStore('ajax_requests', 'readwrite').delete(savedRequest.id);
                    }).catch(function (error) {
                        console.error('Send to Server failed:', error);
                        throw error;
                    })
                }
            }
        }
    }
}

function storePostRequest(url, payload) {
    indexedDB.open(cacheName + '-ajax').onsuccess = function (event) {
        if (payload != "") {
            event.target.result.transaction('ajax_requests', 'readwrite').objectStore('ajax_requests').add({
                url: url,
                payload: payload,
                method: 'POST'
            }).onsuccess = function (event) {
                console.log('POST Request added to IndexedDB');
                messageData = "";
            };
        }
    }
}

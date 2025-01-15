const CACHE_NAME = 'zavody-cache-v1';
const OFFLINE_URL = '/offline';
const API_CACHE_NAME = 'zavody-api-cache-v1';

// soubory k cachování
const urlsToCache = [

    '/offline',
    '/build/assets/app-2xG4YWu7.css',
    '/build/assets/app-DxvN5yQS.js',
    '/zavody',
    '/manifest.json',
    // Přidejte další statické assety

];






// Instalace Service Workeru
console.log('Service Worker loaded');
self.addEventListener('install', event => {
    event.waitUntil(
        Promise.all([
            caches.open(CACHE_NAME)
                .then(cache => cache.addAll(urlsToCache)),
            caches.open(API_CACHE_NAME)
        ])
    );
});

// Aktivace Service Workeru
self.addEventListener('activate', event => {
    event.waitUntil(
        Promise.all([
            caches.keys().then(cacheNames => {
                return Promise.all(
                    cacheNames
                        .filter(cacheName => (cacheName.startsWith('zavody-')))
                        .map(cacheName => caches.delete(cacheName))
                );
            }),
            // Zajistí, že service worker převezme kontrolu okamžitě
            self.clients.claim()
        ])
    );
});

// Zachycení fetch událostí
self.addEventListener('fetch', event => {
    // Rozlišení mezi API požadavky a statickým obsahem
    if (event.request.url.includes('/api/')) {
        // Strategie pro API požadavky: Network first, fallback to cache
        event.respondWith(
            fetch(event.request)
                .then(response => {
                    const clonedResponse = response.clone();
                    caches.open(API_CACHE_NAME)
                        .then(cache => cache.put(event.request, clonedResponse));
                    return response;
                })
                .catch(() => caches.match(event.request))
        );
    } else if (event.request.method === 'GET') {
        // Strategie pro statický obsah: Cache first, fallback to network
        event.respondWith(
            caches.match(event.request)
                .then(response => {
                    if (response) {
                        return response;
                    }

                    return fetch(event.request)
                        .then(response => {
                            if (!response || response.status !== 200 || response.type !== 'basic') {
                                return response;
                            }

                            const responseToCache = response.clone();
                            caches.open(CACHE_NAME)
                                .then(cache => {
                                    cache.put(event.request, responseToCache);
                                });

                            return response;
                        })
                        .catch(() => {
                            if (event.request.mode === 'navigate') {
                                return caches.match(OFFLINE_URL);
                            }
                            return null;
                        });
                })
        );
    }
});

// Sync událost pro offline data
self.addEventListener('sync', event => {
    if (event.tag === 'sync-ulovky') {
        event.waitUntil(syncUlovky());
    }
});

// Funkce pro synchronizaci offline úlovků
async function syncUlovky() {
    try {
        const clients = await self.clients.matchAll();
        clients.forEach(client => {
            // Pokus o synchronizaci dat z localStorage
            client.postMessage({
                type: 'SYNC_REQUIRED'
            });
        });
    } catch (error) {
        console.error('Sync failed:', error);
    }
}

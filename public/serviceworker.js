const CACHE_NAME = 'rybarsky-zapisy-cache-v1';
const URLS_TO_CACHE = ['/', '/manifest.json', '/images/icons/icon-144x144.png', '/favicon.ico',
'/resources/css/app.css',];

// Instalace Service Workeru
self.addEventListener('install', (event) => {
    console.log('Service Worker: Instalace...');
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            console.log('Service Worker: Cachování souborů');
            return cache.addAll(URLS_TO_CACHE);
        })
    );
});

// Aktivace Service Workeru
self.addEventListener('activate', (event) => {
    console.log('Service Worker: Aktivace...');
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cache) => {
                    if (cache !== CACHE_NAME) {
                        console.log('Service Worker: Odstraňování staré cache:', cache);
                        return caches.delete(cache);
                    }
                })
            );
        })
    );
});

// Zachytávání požadavků
self.addEventListener('fetch', (event) => {
    console.log('Service Worker: Fetch zachycen pro:', event.request.url);
    event.respondWith(
        caches.match(event.request).then((response) => {
            return response || fetch(event.request);
        })
    );
});

// Zpracování zpráv od klienta
self.addEventListener('message', (event) => {
    console.log('Service Worker: Zpráva zachycena:', event.data);

    if (event.data.type === 'CACHE_URL') {
        const urlToCache = event.data.url;
        console.log(`Service Worker: Přidání URL do cache: ${urlToCache}`);

        caches.open(CACHE_NAME).then((cache) => {
            cache.add(urlToCache).then(() => {
                console.log(`Service Worker: URL ${urlToCache} úspěšně přidáno do cache.`);
            }).catch((error) => {
                console.error(`Service Worker: Chyba při přidávání URL ${urlToCache} do cache:`, error);
            });
        });
    }
});

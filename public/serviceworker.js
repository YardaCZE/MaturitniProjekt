const CACHE_NAME = 'rybarsky-zapisy-cache-v1';
const URLS_TO_CACHE = [ '/manifest.json', '/images/icons/icon-144x144.png', '/favicon.ico',
"/dashboard",
    "/zavody",
];



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
        fetch(event.request, { redirect: 'follow' })
            .then((response) => {
                if (response.type === 'opaqueredirect') {
                    console.error('Service Worker: Přesměrování detekováno a ignorováno:', response.url);
                    return Response.error();
                }
                return response;
            })
            .catch((error) => {
                console.error('Service Worker: Chyba při fetch:', error);
                return caches.match(event.request);
            })
    );
});



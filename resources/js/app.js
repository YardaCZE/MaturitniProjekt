import './bootstrap.js';

import 'flowbite';

if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/serviceworker.js').then((registration) => {
        console.log('Service Worker registrován:', registration);
    }).catch(error => {
        console.error('Chyba při registraci Service Workeru:', error);
    });
}

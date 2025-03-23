import './bootstrap.js';
import 'flowbite';

if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/serviceworker.js').then((registration) => {
        console.log('Service Worker registrován:', registration);
    });
}

function saveCurrentPageToCache() {
    const currentUrl = window.location.pathname;
    if (navigator.serviceWorker.controller) {
        console.log(`Posílám zprávu do Service Workeru s URL: ${currentUrl}`);
        navigator.serviceWorker.controller.postMessage({
            type: 'CACHE_URL',
            url: currentUrl,
        });
        alert(`URL ${currentUrl} bylo přidáno do cache.`);
    } else {
        alert('Service Worker není aktivní.');
        console.log('Service Worker není dostupný:', navigator.serviceWorker.controller);
    }
}

document.querySelector('#saveButton').addEventListener('click', saveCurrentPageToCache);

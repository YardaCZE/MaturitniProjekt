<x-app-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="max-w-md w-full bg-white shadow-lg rounded-lg p-8 text-center">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Jste offline</h2>
            <p class="text-gray-600 mb-4">
                Připojení k internetu není momentálně k dispozici. Některé funkce mohou být omezené.
            </p>
            <p class="text-gray-600">
                Pokud jste si stáhli závod pro offline použití, měli byste mít přístup k jeho datům.
            </p>
            <button onclick="window.location.reload()" class="mt-6 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Zkusit znovu
            </button>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Zapsat úlovek
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-10">
        <div id="offlineAlert" class="hidden bg-yellow-100 text-yellow-800 p-4 rounded mb-4">
            Jste offline - data budou uložena lokálně a synchronizována po připojení k internetu
        </div>

        @if ($errors->any())
            <div class="bg-red-500 text-white rounded p-4 mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="ulovekForm" method="POST" action="{{ route('ulovek.store', $id) }}">
            @csrf
            <div class="mb-4">
                <label for="id_zavodnika" class="block text-gray-700">Vyber závodníka:</label>
                <select name="id_zavodnika" id="id_zavodnika" class="select2 border rounded w-full py-2 px-3" required>
                    @foreach($zavodnici as $zavodnik)
                        <option value="{{ $zavodnik->id }}">
                            {{ $zavodnik->jmeno }} {{ $zavodnik->prijmeni }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="druh_ryby" class="block text-gray-700">Druh ryby:</label>
                <input type="text" name="druh_ryby" id="druh_ryby" class="border rounded w-full py-2 px-3" required>
            </div>

            <div class="mb-4">
                <label for="delka" class="block text-gray-700">Délka (cm):</label>
                <input type="number" name="delka" id="delka" class="border rounded w-full py-2 px-3">
            </div>

            <div class="mb-4">
                <label for="vaha" class="block text-gray-700">Váha (kg):</label>
                <input type="number" name="vaha" id="vaha" class="border rounded w-full py-2 px-3">
            </div>

            <div class="mb-4">
                <label for="body" class="block text-gray-700">Body:</label>
                <input type="number" name="body" id="body" class="border rounded w-full py-2 px-3" required>
            </div>

            <div>
                <x-button type="submit" class="bg-blue-500 text-white rounded py-2 px-4 hover:bg-blue-700">
                    Zapsat úlovek
                </x-button>
            </div>
        </form>
    </div>

    <script>
        // Kontrola offline/online stavu
        function updateOfflineStatus() {
            const offlineAlert = document.getElementById('offlineAlert');
            if (!navigator.onLine) {
                offlineAlert.classList.remove('hidden');
            } else {
                offlineAlert.classList.add('hidden');
            }
        }

        window.addEventListener('online', updateOfflineStatus);
        window.addEventListener('offline', updateOfflineStatus);
        updateOfflineStatus();

        // Zpracování formuláře
        document.getElementById('ulovekForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const data = {
                id_zavodu: {{ $id }},
                id_zavodnika: formData.get('id_zavodnika'),
                druh_ryby: formData.get('druh_ryby'),
                delka: formData.get('delka'),
                vaha: formData.get('vaha'),
                body: formData.get('body'),
                timestamp: new Date().getTime()
            };

            if (!navigator.onLine) {
                // Offline - uložit do localStorage
                const offlineUlovky = JSON.parse(localStorage.getItem('offline_ulovky_' + {{ $id }}) || '[]');
                offlineUlovky.push(data);
                localStorage.setItem('offline_ulovky_' + {{ $id }}, JSON.stringify(offlineUlovky));

                alert('Úlovek byl uložen offline a bude synchronizován po připojení k internetu');
                this.reset();
                return;
            }

            try {
                // Online - odeslat na server
                const response = await fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': formData.get('_token')
                    },
                    body: JSON.stringify(data)
                });

                if (response.ok) {
                    alert('Úlovek byl úspěšně uložen');
                    window.location.href = '{{ route('zavody.detail', $id) }}';
                } else {
                    throw new Error('Chyba při ukládání');
                }
            } catch (error) {
                console.error('Chyba:', error);
                alert('Došlo k chybě při ukládání úlovku');
            }
        });

        // Synchronizace offline dat
        window.addEventListener('online', async function() {
            const offlineUlovky = JSON.parse(localStorage.getItem('offline_ulovky_' + {{ $id }}) || '[]');

            if (offlineUlovky.length > 0) {
                for (const ulovek of offlineUlovky) {
                    try {
                        const response = await fetch('{{ route('ulovek.store', $id) }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify(ulovek)
                        });

                        if (response.ok) {
                            // Odstranit synchronizovaný úlovek
                            const updatedUlovky = offlineUlovky.filter(item => item.timestamp !== ulovek.timestamp);
                            localStorage.setItem('offline_ulovky_' + {{ $id }}, JSON.stringify(updatedUlovky));
                        }
                    } catch (error) {
                        console.error('Chyba při synchronizaci:', error);
                    }
                }
                alert('Offline data byla synchronizována');
            }
        });
    </script>
</x-app-layout>

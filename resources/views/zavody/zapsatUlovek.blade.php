<x-button onclick="ulozitZavodnikyDoLocalStorage()">Načíst závodníky do Local Storage</x-button>

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

<script>
    let zavodnici = [];

    // Funkce pro načtení závodníků do Local Storage
    function ulozitZavodnikyDoLocalStorage() {
        zavodnici = @json($zavodnici);
        localStorage.setItem('zavodnici', JSON.stringify(zavodnici));
        alert('Závodníci byli uloženi do Local Storage!');
    }

    // Formulář pro zapsání úlovku
    const ulovekForm = document.getElementById('ulovekForm');
    ulovekForm.addEventListener('submit', function (event) {
        event.preventDefault(); // Zabrání standardnímu odeslání formuláře

        const id_zavodnika = document.getElementById('id_zavodnika').value;
        const druh_ryby = document.getElementById('druh_ryby').value;
        const delka = document.getElementById('delka').value;
        const vaha = document.getElementById('vaha').value;
        const body = document.getElementById('body').value;

        const ulovek = {
            id_zavodnika,
            druh_ryby,
            delka,
            vaha,
            body
        };

        if (navigator.onLine) {
            // Uživatel je online, data se odešlou přímo
            fetch('{{ route('ulovek.store', $id) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(ulovek)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert('Chyba: ' + data.error);
                    } else {
                        alert('Úlovek byl úspěšně uložen!');
                    }
                })
                .catch(error => {
                    console.error('Chyba:', error);
                    alert('Došlo k chybě při odesílání úlovku.');
                });
        } else {
            // Uživatel je offline, data se uloží do Local Storage
            const offlineUlovky = JSON.parse(localStorage.getItem('offlineUlovky')) || [];
            offlineUlovky.push(ulovek);
            localStorage.setItem('offlineUlovky', JSON.stringify(offlineUlovky));
            alert('Úlovek byl uložen do Local Storage!');
        }
    });

    // Zkontroluje offline úlovky a odešle je, pokud je uživatel online
    window.addEventListener('online', () => {
        const offlineUlovky = JSON.parse(localStorage.getItem('offlineUlovky')) || [];
        if (offlineUlovky.length > 0) {
            offlineUlovky.forEach(ulovek => {
                fetch('{{ route('ulovek.store', $id) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(ulovek)
                })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.error) {
                            console.log('Úlovek byl úspěšně odeslán:', ulovek);
                        }
                    })
                    .catch(error => console.error('Chyba při odesílání úlovku:', error));
            });

            // Po úspěšném odeslání se offline úlovky vyčistí
            localStorage.removeItem('offlineUlovky');
        }
    });
</script>

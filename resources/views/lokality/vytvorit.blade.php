<x-app-layout>
    <head>
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    </head>
    <div class="container mx-auto px-4 max-w-lg">

        <h1 class="text-2xl font-semibold mb-6 text-gray-700 text-center">Vytvořit lokalitu</h1>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('lokality.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
            @csrf

            <div class="mb-4">
                <label for="nazev_lokality" class="block text-gray-700 font-medium mb-2">Název lokality</label>
                <input type="text" name="nazev_lokality" required class="form-input w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="druh" class="block text-gray-700 font-medium mb-2">Druh</label>
                <select name="druh" required class="form-select w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Vyberte druh</option>
                    @foreach ($druhy as $druh)
                        <option value="{{ $druh->druh }}">{{ $druh->druh }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="rozloha" class="block text-gray-700 font-medium mb-2">Rozloha (v ha)</label>
                <input type="number" step="0.01" name="rozloha" required class="form-input w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="kraj" class="block text-gray-700 font-medium mb-2">Lokalita (automaticky doplněno)</label>
                <input type="text" id="kraj" name="kraj" required class="form-input w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500" readonly>
            </div>

            <div class="mb-4">
                <label for="souradnice" class="block text-gray-700 font-medium mb-2">Souřadnice</label>
                <input type="text" id="souradnice" name="souradnice" required class="form-input w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500" readonly>
                <div id="map" style="height: 300px; width: 100%;"></div>
            </div>

            <!-- Checkbox pro soukromí -->
            <div class="mb-4">
                <label for="soukroma" class="inline-flex items-center text-gray-700">
                    <input type="checkbox" id="soukroma" name="soukroma" value="1" class="form-checkbox text-indigo-600" />
                    <span class="ml-2">Lokalita je soukromá</span>
                </label>
            </div>

            <!-- Checkbox pro soukromí pro skupinu a osobu -->
            <div id="soukromi-volby" class="hidden">
                <div class="mb-4">
                    <label for="souk_skup" class="inline-flex items-center text-gray-700">
                        <input type="checkbox" id="souk_skup" name="souk_skup" value="1" class="form-checkbox text-indigo-600" />
                        <span class="ml-2">Lokalita je soukromá pro skupinu</span>
                    </label>
                </div>

                <div id="skupina-select" class="mb-4 hidden">
                    <label for="soukSkupID" class="block text-gray-700 font-medium mb-2">Vyberte skupinu</label>
                    <select name="soukSkupID" id="soukSkupID" class="form-select w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Vyberte skupinu</option>
                        @foreach ($vsechnySkupiny as $skupina)
                            <option value="{{ $skupina->id }}">{{ $skupina->nazev_skupiny }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="soukOsob" class="inline-flex items-center text-gray-700">
                        <input type="checkbox" id="soukOsob" name="soukOsob" value="1" class="form-checkbox text-indigo-600" />
                        <span class="ml-2">Lokalita je soukromá pouze pro uživatele</span>
                    </label>
                </div>
            </div>

            <x-button type="submit" class="bg-primarni text-white font-semibold py-3 rounded-md shadow-md hover:bg-primarniDarker focus:outline-none focus:ring-2 focus:ring-indigo-500">
                Vytvořit
            </x-button>
        </form>
    </div>

    <script>
        // Zobrazení/skrytí soukromí volby na základě checkboxu
        document.getElementById('soukroma').addEventListener('change', function() {
            const soukromiVolby = document.getElementById('soukromi-volby');
            soukromiVolby.style.display = this.checked ? 'block' : 'none';
        });

        document.getElementById('souk_skup').addEventListener('change', function() {
            const skupinaSelect = document.getElementById('skupina-select');
            skupinaSelect.style.display = this.checked ? 'block' : 'none';
        });

        const map = L.map('map').setView([50.0755, 14.4378], 8); // Výchozí poloha (Praha)

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        const marker = L.marker([50.0755, 14.4378]).addTo(map).bindPopup('Vyberte místo!').openPopup();

        map.on('click', function(e) {
            placeMarker(e.latlng);
        });

        function placeMarker(latlng) {
            marker.setLatLng(latlng);
            document.getElementById("souradnice").value = latlng.lat + ", " + latlng.lng;
            getRegion(latlng.lat, latlng.lng);
        }

        marker.dragging.enable();
        marker.on('dragend', function(event) {
            const position = marker.getLatLng();
            document.getElementById("souradnice").value = position.lat + ", " + position.lng;
            getRegion(position.lat, position.lng);
        });

        function getRegion(lat, lon) {
            fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lon}&format=json`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.address && data.address.state) {
                        document.getElementById("kraj").value = data.address.state; // Aktualizace pole kraje
                    }
                })
                .catch(error => console.error('Error fetching region:', error));
        }
    </script>
</x-app-layout>

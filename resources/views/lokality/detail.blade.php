<x-app-layout>
    <div class="container my-5">
        <div class="card p-5 shadow-lg text-center mx-auto" style="max-width: 800px;">
            <h1 class="display-3 font-weight-bold mb-4">{{ $lokalita->nazev_lokality }}</h1>
            <x-button class=" btn btn-primary mt-4 " id="showUploadForm">Přidat fotku</x-button>

            <div class="text-lg mb-4">
                <p><strong>Druh:</strong> {{ $lokalita->druh }}</p>
                <p><strong>Rozloha:</strong> {{ $lokalita->rozloha }} ha</p>
                <p><strong>Kraj:</strong> {{ $lokalita->kraj }}</p>
                <p><strong>Souřadnice:</strong> {{ $lokalita->souradnice }}</p>
                <p><strong>Zakladatel:</strong> {{ $lokalita->zakladatel->name ?? 'N/A' }}</p>
            </div>

            <!-- Mapa -->
            <div class="mt-5">
                <h3 class="text-xl font-semibold text-gray-800">Mapa lokality:</h3>
                <div id="map" style="height: 400px;"></div>
            </div>

            <h2 class="display-5 mt-5 mb-3">Obrázky lokality</h2>
            <div class="d-flex flex-wrap justify-content-center">
                @if($lokalita->obrazky->isEmpty())
                    <p class="text-muted">Žádné obrázky nejsou k dispozici.</p>
                @else
                    @foreach($lokalita->obrazky as $obrazek)
                        <div class="m-2" style="width: 200px; height: 150px; overflow: hidden; border-radius: 10px; cursor: pointer;"
                             onclick="showModal('{{ asset($obrazek->cesta_k_obrazku) }}')">
                            <img src="{{ asset($obrazek->cesta_k_obrazku) }}" class="img-fluid" alt="Obrázek lokality" style="object-fit: cover; width: 100%; height: 100%;">
                        </div>
                    @endforeach
                @endif
            </div>
        </div>


        <div id="uploadOverlay" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center hidden">
            <div class="bg-white w-full sm:w-3/4 lg:w-1/2 p-8 rounded-lg shadow-lg">
                <h3 class="text-xl font-semibold mb-4">Nahrát obrázky</h3>
                <form action="{{ route('lokality.nahratObrazek', $lokalita->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="obrazek">Vyberte obrázek k nahrání:</label>
                        <input type="file" name="obrazky[]" id="obrazek" class="form-control" multiple required>
                    </div>
                    <div class="d-flex justify-between">
                        <x-button type="button" onclick="toggleUploadOverlay()" class="btn btn-secondary mt-2">Zavřít</x-button>
                        <x-button type="submit" class="btn btn-success mt-2">Nahrát obrázek</x-button>

                    </div>
                </form>
            </div>
        </div>


        <div id="imageModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <img id="modalImage" src="" class="img-fluid" alt="Zvětšený obrázek">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Zavřít</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <script>
            document.getElementById('showUploadForm').addEventListener('click', function () {
                toggleUploadOverlay();
            });

            function toggleUploadOverlay() {
                const overlay = document.getElementById('uploadOverlay');
                overlay.classList.toggle('hidden');
            }

            function showModal(imageSrc) {
                const modalImage = document.getElementById('modalImage');
                modalImage.src = imageSrc;
                $('#imageModal').modal('show');
            }

            // Inicializace mapy
            const souradnice = '{{ $lokalita->souradnice }}';
            const coords = souradnice.split(',').map(Number);
            const map = L.map('map').setView(coords, 13);


            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(map);


            L.marker(coords).addTo(map)
                .bindPopup('{{ $lokalita->nazev_lokality }}')
                .openPopup();
        </script>
    </div>
</x-app-layout>

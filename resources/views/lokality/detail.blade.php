<x-app-layout>
    <div class="container my-5">
        <div class="card p-5 shadow-lg text-center mx-auto" style="max-width: 800px;">
            <h1 class="display-3 font-weight-bold mb-4">{{ $lokalita->nazev_lokality }}</h1>

            <div class="text-lg mb-4">
                <p><strong>Druh:</strong> {{ $lokalita->druh }}</p>
                <p><strong>Rozloha:</strong> {{ $lokalita->rozloha }} m²</p>
                <p><strong>Kraj:</strong> {{ $lokalita->kraj }}</p>
                <p><strong>Souřadnice:</strong> {{ $lokalita->souradnice }}</p>
                <p><strong>Zakladatel:</strong> {{ $lokalita->zakladatel->name ?? 'N/A' }}</p>
            </div>

            <h2 class="display-5 mt-5 mb-3">Obrázky lokality</h2>
            <div class="d-flex flex-wrap justify-content-center">
                @if($lokalita->obrazky->isEmpty())
                    <p class="text-muted">Žádné obrázky nejsou k dispozici.</p>
                @else
                    @foreach($lokalita->obrazky as $obrazek)
                        <div class="m-2" style="width: 200px; height: 150px; overflow: hidden; border-radius: 10px;">
                            <img src="{{ asset('storage/' . $obrazek->cesta_k_obrazku) }}" class="img-fluid" alt="Obrázek lokality" style="object-fit: cover; width: 100%; height: 100%;">
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

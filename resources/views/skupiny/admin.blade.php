<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h1 class="text-2xl font-semibold text-gray-800 leading-tight">Admin Panel - Skupina: {{ $skupina->nazev_skupiny }}</h1>

                <form action="{{ route('pozvanky.vytvorit', $skupina->id) }}" method="POST">
                    @csrf
                    <label for="max_pocet_pouziti">Maximální počet použití:</label>
                    <input type="number" name="max_pocet_pouziti" min="1" required>

                    <label for="expirace">Datum expirace (volitelné):</label>
                    <input type="datetime-local" name="expirace">

                    <x-button>Vygenerovat novou pozvánku</x-button>
                </form>

                @php
                    $pozvanky = App\Models\Pozvanka::where('id_skupiny', $skupina->id)->get();
                @endphp

                @if($pozvanky->isNotEmpty())
                    <h2 class="mt-6 text-xl">Aktuální pozvánky:</h2>
                    <ul>
                        @foreach($pozvanky as $pozvanka)
                            <li>
                                Kód: {{ $pozvanka->kod_pozvanky }} |
                                Počet použití: {{ $pozvanka->pocet_pouziti }} / {{ $pozvanka->max_pocet_pouziti ?? 'Neomezeno' }} |
                                Expirace: {{ $pozvanka->expirace ?? 'Bez expirace' }}
                                <form action="{{ route('pozvanky.smazat', $pozvanka->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <x-button class="text-red-500">Smazat</x-button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>Žádné pozvánky nejsou k dispozici.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

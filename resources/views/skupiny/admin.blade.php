<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                <h1 class="text-2xl font-semibold text-gray-800 leading-tight">
                    🛠️ Admin Panel - Skupina: <span class="text-blue-600">{{ $skupina->nazev_skupiny }}</span>
                </h1>

                <h2 class="text-xl font-bold text-gray-800">Vytvořit novou pozvánku</h2>
                <form action="{{ route('pozvanky.vytvorit', $skupina->id) }}" method="POST" class="mt-6 space-y-4">
                    @csrf
                    <div>
                        <label for="max_pocet_pouziti" class="block text-sm font-medium text-gray-700">Maximální počet použití:</label>
                        <input type="number" name="max_pocet_pouziti" min="1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="expirace" class="block text-sm font-medium text-gray-700">Datum expirace (volitelné):</label>
                        <input type="datetime-local" name="expirace" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <x-button class="bg-primarni hover:bg-primarniDarker text-white font-semibold">➕ Vygenerovat novou pozvánku</x-button>
                </form>

                <!-- Seznam pozvánek -->
                <div class="mt-8">
                    @php
                        $pozvanky = App\Models\Pozvanka::where('id_skupiny', $skupina->id)->get();
                    @endphp

                    @if($pozvanky->isNotEmpty())
                        <h2 class="text-xl font-bold text-gray-800">🔗 Aktuální pozvánky:</h2>
                        <ul class="mt-4 space-y-4">
                            @foreach($pozvanky as $pozvanka)
                                <li class="p-4 bg-gray-100 rounded-lg shadow-md flex justify-between items-center">
                                    <div>
                                        <p class="text-sm text-gray-700">Kód: <span class="font-semibold text-blue-600 text-lg">{{ $pozvanka->kod_pozvanky }}</span></p>                                        <p class="text-sm text-gray-700">Počet použití: {{ $pozvanka->pocet_pouziti }} / {{ $pozvanka->max_pocet_pouziti ?? 'Neomezeno' }}</p>
                                        <p class="text-sm text-gray-700">Expirace: {{ $pozvanka->expirace ?? 'Bez expirace' }}</p>
                                    </div>
                                    <div class="flex space-x-4 items-center">
                                        <button class="bg-sekundarni hover:bg-gray-400 text-sm text-black font-semibold py-2 px-4 rounded-md" onclick="navigator.clipboard.writeText('{{ $pozvanka->kod_pozvanky }}')">📋 Zkopírovat kód</button>
                                        <form action="{{ route('pozvanky.smazat', $pozvanka->id) }}" method="POST" onsubmit="return confirm('Opravdu chcete tuto pozvánku smazat?');">
                                            @csrf
                                            @method('DELETE')
                                            <x-button class="bg-pozor hover:bg-red-700 text-white">🗑️ Smazat</x-button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500">Žádné pozvánky nejsou k dispozici.</p>
                    @endif
                </div>

                <hr class="my-8 border-gray-300">

                <!-- Seznam členů skupiny -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800">👥 Členové skupiny:</h2>
                    <ul class="mt-4 space-y-4">
                        @foreach($cleni as $clen)
                            <li class="p-4 bg-gray-100 rounded-lg shadow-md flex justify-between items-center">
                                <div>
                                    <p class="text-sm text-gray-700">Jméno: <span class="font-semibold text-gray-900">{{ $clen->uzivatel->name }}</span></p>
                                    <p class="text-sm text-gray-700">Email: {{ $clen->uzivatel->email }}</p>
                                </div>
                                <div class="flex space-x-2">
                                    @if($clen->uzivatel->id !== $skupina->id_admin && !$clen->uzivatel->isAdmin())
                                        @if($skupina->moderatori->contains('id_uzivatele', $clen->uzivatel->id))
                                            <span class="text-blue-600">(Moderátor)</span>
                                            <form action="{{ route('moderatori.odebrat', ['idSkupiny' => $skupina->id, 'idUzivatele' => $clen->uzivatel->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <x-button class="bg-pozor hover:bg-yellow-700 text-white">⬇️ Odebrat moderátora</x-button>
                                            </form>
                                        @else
                                            <form action="{{ route('moderatori.pridat', ['idSkupiny' => $skupina->id, 'idUzivatele' => $clen->uzivatel->id]) }}" method="POST">
                                                @csrf
                                                <x-button class="bg-primarni hover:bg-primarniDarker text-white">⬆️ Udělit moderátora</x-button>
                                            </form>
                                        @endif
                                    @else
                                        <span class="text-red-600">(Administrátor)</span>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

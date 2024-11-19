<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h1 class="text-2xl font-semibold text-gray-800 leading-tight">Admin Panel - Skupina: {{ $skupina->nazev_skupiny }}</h1>

                <form action="{{ route('pozvanky.vytvorit', $skupina->id) }}" method="POST">
                    @csrf
                    <label for="max_pocet_pouziti">Maximální počet použití:</label>
                    <input type="number"  name="max_pocet_pouziti" min="1"  >

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
                            <p>
                              <!--  Kód: <x-copy-card text="{{$pozvanka->kod_pozvanky }}" /> -->
                                Kód: {{ $pozvanka->kod_pozvanky }} |
                                Počet použití: {{ $pozvanka->pocet_pouziti }} / {{ $pozvanka->max_pocet_pouziti ?? 'Neomezeno' }} |
                                Expirace: {{ $pozvanka->expirace ?? 'Bez expirace' }}
                                <form action="{{ route('pozvanky.smazat', $pozvanka->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <x-button class="bg-red-600 hover:bg-red-700">Smazat</x-button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>Žádné pozvánky nejsou k dispozici.</p>
                @endif
                <hr class="my-8 border-gray-300" />
                <h2 class="mt-6 text-xl">Členové skupiny:</h2>
                <ul>
                    @foreach($cleni as $clen)
                        <li>
                            Jméno: {{ $clen->uzivatel->name }} |
                            Email: {{ $clen->uzivatel->email }} |
                            @if($clen->uzivatel->id !== $skupina->id_admin && !$clen->uzivatel->isAdmin())
                                @if($skupina->moderatori->contains('id_uzivatele', $clen->uzivatel->id))
                                    <span class="text-blue-600">(Moderátor)</span>
                                    <form action="{{ route('moderatori.odebrat', ['idSkupiny' => $skupina->id, 'idUzivatele' => $clen->uzivatel->id]) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <x-button class="bg-yellow-600 hover:bg-yellow-700">Odebrat moderátora</x-button>
                                    </form>
                                @else
                                    <form action="{{ route('moderatori.pridat', ['idSkupiny' => $skupina->id, 'idUzivatele' => $clen->uzivatel->id]) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <x-button class="bg-green-600 hover:bg-green-700">Udělit moderátora</x-button>
                                    </form>
                                @endif
                            @else
                                <span class="text-red-600">(Administrátor)</span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>
</x-app-layout>

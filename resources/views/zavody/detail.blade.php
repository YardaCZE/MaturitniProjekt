<x-app-layout>
    <div class="max-w-7xl mx-auto mt-10 p-8 bg-sekundarni rounded-lg shadow-lg border border-gray-200">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-4xl font-extrabold text-primarni">
                Závod: <span class="text-primarni">{{ $zavod->nazev }}</span>
            </h1>
            <img src="https://i.etsystatic.com/11678415/r/il/02b421/2049909910/il_fullxfull.2049909910_rwql.jpg" alt="Fishing banner" class="h-20 rounded-lg shadow-md">
        </div>

        <div class="mb-6 flex items-center">
            <span class="px-4 py-2 rounded-full text-sm font-semibold
                         {{ $zavod->stav == 2 ? 'bg-[#EED3B1] text-[#1F4529]' : 'bg-[#E8ECD7] text-[#47663B]' }}">
                {{ $zavod->stav == 2 ? 'Závod je ukončený' : 'Závod je aktivní' }}
            </span>
        </div>

        @if (session('error'))
            <div class="mb-4 p-4 bg-[#EED3B1] text-[#1F4529] border border-[#47663B] rounded">
                {{ session('error') }}
            </div>
        @endif

        @if(auth()->user()->isAdmin() || auth()->user()->id === $zavod->id_zakladatele)
            <div class="mb-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('zavody.pridatZavodnika', $zavod->id) }}">
                    <x-button class="bg-primarni hover:bg-primarniDarker w-full">Přidat účastníka</x-button>
                </a>
                <a href="{{ route('zavody.pridatMerice', $zavod->id) }}">
                    <x-button class="bg-primarni hover:bg-primarniDarker w-full">Přidat měřiče</x-button>
                </a>

                <a href="{{ route('zavody.pridatPozorovatele', $zavod->id) }}">
                    <x-button class="bg-primarni hover:bg-primarniDarker w-full">Přidat pozorovatele</x-button>
                </a>
                @if($zavod->stav == 2)
                    <form action="{{ route('zavody.aktivovat', $zavod->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <x-button class="bg-pozor hover:bg-[#47663B] w-full" type="submit">
                            Znovu aktivovat závod
                        </x-button>
                    </form>
                @else
                    <form action="{{ route('zavody.ukoncit', $zavod->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <x-button class="bg-pozor hover:bg-pozor w-full" type="submit">
                            Ukončit závod
                        </x-button>
                    </form>
                @endif
            </div>
        @endif

        @if($jeMeric)
            <div class="mb-6 text-center grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 justify-center">
                <a href="{{ route('zavody.zapsatUlovek', $zavod->id) }}">
                    <x-button class="bg-primarni hover:bg-primarniDarker w-full">Zapsat Úlovek</x-button>
                </a>
            </div>

        @endif

        <div class="mb-10">
            <h2 class="text-2xl font-semibold text-primarni mb-4 text-center">TOP závodu</h2>
            <div class="bg-white rounded-lg shadow-md p-6">
                @if ($nejdelsiRyba || $nejtezsiRyba || $nejbodovanesiRyba)
                    <ul class="space-y-2 text-primarni text-center">
                        @if ($nejdelsiRyba)
                            <li><span class="font-bold">Nejdelší ryba:</span> {{ $nejdelsiRyba->druh_ryby }} {{ $nejdelsiRyba->delka }} cm</li>
                        @else
                            <li><span class="font-bold">Nejdelší ryba:</span> Zatím žádný úlovek</li>
                        @endif

                        @if ($nejtezsiRyba)
                            <li><span class="font-bold">Nejtěžší ryba:</span> {{ $nejtezsiRyba->druh_ryby }} {{ $nejtezsiRyba->vaha }} kg</li>
                        @else
                            <li><span class="font-bold">Nejtěžší ryba:</span> Zatím žádný úlovek</li>
                        @endif

                        @if ($nejbodovanesiRyba)
                            <li><span class="font-bold">Nejbodovanější ryba:</span> {{ $nejbodovanesiRyba->druh_ryby }} {{ $nejbodovanesiRyba->body }} bodů</li>
                        @else
                            <li><span class="font-bold">Nejbodovanější ryba:</span> Zatím žádný úlovek</li>
                        @endif
                    </ul>
                @else
                    <p class="text-center text-primarni">Zatím nebyl chycen žádný úlovek.</p>
                @endif
            </div>
        </div>


        <div>
            <h2 class="text-2xl font-semibold text-primarni mb-4 text-center">Seznam závodníků</h2>
            @if ($zavodnici->isEmpty())
                <p class="text-primarni">Žádní závodníci nebyli zatím přidáni.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="table-auto w-full bg-white rounded-lg shadow-md">
                        <thead>
                        <tr class="text-primarni">
                            <th class="px-4 py-2 text-left">Umístění</th>
                            <th class="px-4 py-2 text-left">Jméno</th>
                            <th class="px-4 py-2 text-left">Příjmení</th>
                            <th class="px-4 py-2 text-left">Datum narození</th>
                            <th class="px-4 py-2 text-left">Body</th>
                            <th class="px-4 py-2 text-left">Akce</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($zavodnici as $zavodnik)
                            <tr class="text-primarni">
                                <td class="px-4 py-2 text-pozor">{{ $zavodnik->umisteni }}</td>
                                <td class="px-4 py-2">{{ $zavodnik->jmeno }}</td>
                                <td class="px-4 py-2">{{ $zavodnik->prijmeni }}</td>
                                <td class="px-4 py-2">{{ $zavodnik->datum_narozeni }}</td>
                                <td class="px-4 py-2 ">{{ $zavodnik->body_celkem }}</td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('zavody.ulovky', [$zavodnik->id, $zavod->id]) }}">
                                        <button class="bg-primarni text-white px-4 py-2 rounded hover:bg-primarniDarker">Úlovky</button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

</x-app-layout>




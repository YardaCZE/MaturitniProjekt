<x-app-layout>
    <div class="max-w-7xl mx-auto mt-10 p-8 bg-gradient-to-br from-[#E8ECD7] to-[#EED3B1] rounded-lg shadow-lg border border-gray-200">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-4xl font-extrabold text-[#1F4529]">
                Závod: <span class="text-[#47663B]">{{ $zavod->nazev }}</span>
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
                    <x-button class="bg-[#47663B] hover:bg-[#1F4529] w-full">Přidat účastníka</x-button>
                </a>
                <a href="{{ route('zavody.pridatMerice', $zavod->id) }}">
                    <x-button class="bg-[#47663B] hover:bg-[#1F4529] w-full">Přidat měřiče</x-button>
                </a>

                <a href="{{ route('zavody.pridatPozorovatele', $zavod->id) }}">
                    <x-button class="bg-[#47663B] hover:bg-[#1F4529] w-full">Přidat pozorovatele</x-button>
                </a>
                @if($zavod->stav == 2)
                    <form action="{{ route('zavody.aktivovat', $zavod->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <x-button class="bg-[#EED3B1] hover:bg-[#47663B] w-full" type="submit">
                            Znovu aktivovat závod
                        </x-button>
                    </form>
                @else
                    <form action="{{ route('zavody.ukoncit', $zavod->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <x-button class="bg-red-600 hover:bg-[#1F4529] w-full" type="submit">
                            Ukončit závod
                        </x-button>
                    </form>
                @endif
            </div>
        @endif

        @if(auth()->user()->isAdmin() || $jeMeric)
            <div class="mb-6">
                <a href="{{ route('zavody.zapsatUlovek', $zavod->id) }}">
                    <x-button class="bg-[#47663B] hover:bg-[#1F4529] w-full">Zapsat Úlovek</x-button>
                </a>
            </div>
        @endif

        <div class="mb-10">
            <h2 class="text-2xl font-semibold text-[#1F4529] mb-4">TOP závodu</h2>
            <div class="bg-[#E8ECD7] rounded-lg shadow-md p-6">
                <ul class="space-y-2">
                    <li class="text-[#47663B]"><span class="font-bold">Nejdelší ryba:</span> {{ $nejdelsiRyba->druh_ryby }} {{ $nejdelsiRyba->delka }} cm</li>
                    <li class="text-[#47663B]"><span class="font-bold">Nejtěžší ryba:</span> {{ $nejtezsiRyba->druh_ryby }} {{ $nejtezsiRyba->vaha }} kg</li>
                    <li class="text-[#47663B]"><span class="font-bold">Nejbodovanější ryba:</span> {{ $nejbodovanesiRyba->druh_ryby }} {{ $nejbodovanesiRyba->body }} bodů</li>
                </ul>
            </div>
        </div>

        <div>
            <h2 class="text-2xl font-semibold text-[#1F4529] mb-4">Seznam závodníků</h2>
            @if ($zavodnici->isEmpty())
                <p class="text-[#47663B]">Žádní závodníci nebyli zatím přidáni.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="table-auto w-full bg-[#E8ECD7] rounded-lg shadow-md">
                        <thead>
                        <tr>
                            <th class="px-4 py-2 text-left text-[#47663B]">Umístění</th>
                            <th class="px-4 py-2 text-left text-[#47663B]">Jméno</th>
                            <th class="px-4 py-2 text-left text-[#47663B]">Příjmení</th>
                            <th class="px-4 py-2 text-left text-[#47663B]">Datum narození</th>
                            <th class="px-4 py-2 text-left text-[#47663B]">Body</th>
                            <th class="px-4 py-2 text-left text-[#47663B]">Akce</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($zavodnici as $zavodnik)
                            <tr>
                                <td class="px-4 py-2 text-[#47663B]">{{ $zavodnik->umisteni }}</td>
                                <td class="px-4 py-2 text-[#47663B]">{{ $zavodnik->jmeno }}</td>
                                <td class="px-4 py-2 text-[#47663B]">{{ $zavodnik->prijmeni }}</td>
                                <td class="px-4 py-2 text-[#47663B]">{{ $zavodnik->datum_narozeni }}</td>
                                <td class="px-4 py-2 text-[#47663B]">{{ $zavodnik->body_celkem }}</td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('zavody.ulovky', [$zavodnik->id, $zavod->id]) }}">
                                        <button class="bg-[#47663B] text-[#E8ECD7] px-4 py-2 rounded hover:bg-[#1F4529]">Úlovky</button>
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

<x-app-layout>
    <div class="max-w-full mx-auto mt-10 p-8 bg-white rounded-lg shadow-lg border border-gray-200">
        <h1 class="text-4xl font-extrabold text-gray-800 mb-6">
            Závod: <span class="text-blue-500">{{ $zavod->nazev }}</span>
        </h1>

        <div class="mb-6">
            <span class="px-4 py-2 rounded-full text-sm font-semibold
                         {{ $zavod->stav == 2 ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }}">
                {{ $zavod->stav == 2 ? 'Závod je ukončený' : 'Závod je aktivní' }}
            </span>
        </div>

        @if (session('error'))
            <div class="mb-4 p-4 bg-red-100 text-red-600 border border-red-300 rounded">
                {{ session('error') }}
            </div>
        @endif

        @if(auth()->user()->isAdmin() || auth()->user()->id === $zavod->id_zakladatele)
            <div class="mb-6 flex flex-wrap gap-4">
                <a href="{{ route('zavody.pridatZavodnika', $zavod->id) }}">
                    <x-button class="bg-blue-600 hover:bg-blue-700">Přidat účastníka</x-button>
                </a>
                <a href="{{ route('zavody.pridatMerice', $zavod->id) }}">
                    <x-button class="bg-blue-600 hover:bg-blue-700">Přidat měřiče</x-button>
                </a>
                @if($zavod->stav == 2)
                    <form action="{{ route('zavody.aktivovat', $zavod->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <x-button class="bg-yellow-600 hover:bg-yellow-700" type="submit">
                            Znovu aktivovat závod
                        </x-button>
                    </form>
                @else
                    <form action="{{ route('zavody.ukoncit', $zavod->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <x-button class="bg-red-600 hover:bg-red-700" type="submit">
                            Ukončit závod
                        </x-button>
                    </form>
                @endif
            </div>
        @endif

        @if(auth()->user()->isAdmin() || $jeMeric)
            <div class="mb-6">
                <a href="{{ route('zavody.zapsatUlovek', $zavod->id) }}">
                    <x-button class="bg-blue-600 hover:bg-blue-700">Zapsat Úlovek</x-button>
                </a>
            </div>
        @endif

        <div class="mb-10">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">TOP závodu</h2>
            <ul class="space-y-2">
                <li class="text-gray-600"><span class="font-bold">Nejdelší ryba:</span> {{ $nejdelsiRyba->druh_ryby }} {{ $nejdelsiRyba->delka }} cm</li>
                <li class="text-gray-600"><span class="font-bold">Nejtěžší ryba:</span> {{ $nejtezsiRyba->druh_ryby }} {{ $nejtezsiRyba->vaha }} kg</li>
                <li class="text-gray-600"><span class="font-bold">Nejbodovanější ryba:</span> {{ $nejbodovanesiRyba->druh_ryby }} {{ $nejbodovanesiRyba->body }} bodů</li>
            </ul>
        </div>

        <div>
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Seznam závodníků</h2>
            @if ($zavodnici->isEmpty())
                <p class="text-gray-600">Žádní závodníci nebyli zatím přidáni.</p>
            @else
                <div class="hidden md:block">
                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-300">
                            <thead>
                            <tr class="bg-gray-100 text-left text-sm">
                                <th class="px-4 py-2 border border-gray-300">Umístění</th>
                                <th class="px-4 py-2 border border-gray-300">Jméno</th>
                                <th class="px-4 py-2 border border-gray-300">Příjmení</th>
                                <th class="px-4 py-2 border border-gray-300">Datum narození</th>
                                <th class="px-4 py-2 border border-gray-300">Body</th>
                                <th class="px-4 py-2 border border-gray-300">Akce</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($zavodnici as $zavodnik)
                                <tr class="hover:bg-gray-50 text-sm">
                                    <td class="px-4 py-2 border border-gray-300 text-red-600">{{ $zavodnik->umisteni }}</td>
                                    <td class="px-4 py-2 border border-gray-300">{{ $zavodnik->jmeno }}</td>
                                    <td class="px-4 py-2 border border-gray-300">{{ $zavodnik->prijmeni }}</td>
                                    <td class="px-4 py-2 border border-gray-300">{{ $zavodnik->datum_narozeni }}</td>
                                    <td class="px-4 py-2 border border-gray-300">{{ $zavodnik->body_celkem }}</td>
                                    <td class="px-4 py-2 border border-gray-300">
                                        <a href="{{ route('zavody.ulovky', [$zavodnik->id, $zavod->id]) }}">
                                            <x-button class="bg-blue-600 hover:bg-blue-700">Úlovky</x-button>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 md:hidden">
                    @foreach ($zavodnici as $zavodnik)
                        <div class="p-6 bg-white border border-gray-300 rounded-lg shadow-md hover:shadow-lg">
                            <h3 class="text-xl font-semibold text-gray-800">{{ $zavodnik->jmeno }} {{ $zavodnik->prijmeni }}</h3>
                            <p class="text-red-400">Umístění: {{ $zavodnik->umisteni }}</p>
                            <p class="text-gray-600">Datum narození: {{ $zavodnik->datum_narozeni }}</p>
                            <p class="text-gray-600">Body: {{ $zavodnik->body_celkem }}</p>
                            <a href="{{ route('zavody.ulovky', [$zavodnik->id, $zavod->id]) }}" class="mt-4 block">
                                <x-button class="bg-blue-600 hover:bg-blue-700">Úlovky</x-button>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

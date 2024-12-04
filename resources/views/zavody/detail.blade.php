
<x-app-layout>

    <div class="max-w-full mx-auto mt-10 p-6 bg-white rounded-lg shadow-md box-border">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">
            Závod: <span class="text-blue-500">{{ $zavod->nazev }}</span>
        </h1>

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if(auth()->user()->isAdmin() || auth()->user()->id === $zavod->id_zakladatele)
            <div class="mb-6">
                <a href="{{ route('zavody.pridatZavodnika', $zavod->id) }}" class="text-white">
                    <x-button>Přidat účastníka</x-button>
                </a>
            </div>
            <a href="{{ route('zavody.pridatMerice', $zavod->id) }}" class="text-white">
                <x-button>Přidat měřiče</x-button>
            </a>
        @endif

        @if(auth()->user()->isAdmin() || $jeMeric)
            <a href="{{ route('zavody.zapsatUlovek', $zavod->id) }}" class="text-white">
                <x-button>Zapsat Úlovek</x-button>
            </a>
        @endif

        <h2 class="text-2xl font-semibold text-gray-700 mb-4">Seznam závodníků</h2>
        @if ($zavodnici->isEmpty())
            <p class="text-gray-600">Žádní závodníci nebyli zatím přidáni.</p>
        @else
            <!-- Tabulka pro desktop (skrytá na mobilu) -->
            <div class="hidden md:block">
                <div class="overflow-x-auto">
                    <table class="min-w-full border-collapse border border-gray-300">
                        <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 px-4 py-2 text-left text-sm">Umístění</th>
                            <th class="border border-gray-300 px-4 py-2 text-left text-sm">Jméno</th>
                            <th class="border border-gray-300 px-4 py-2 text-left text-sm">Příjmení</th>
                            <th class="border border-gray-300 px-4 py-2 text-left text-sm">Datum narození</th>
                            <th class="border border-gray-300 px-4 py-2 text-left text-sm">Body</th>
                            <th class="border border-gray-300 px-4 py-2 text-left text-sm">Akce</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($zavodnici as $zavodnik)
                            <tr class="hover:bg-gray-50">
                                <td class="border border-gry-400 px-4 py-2 text-sm text-red-600">{{ $zavodnik->umisteni }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-sm">{{ $zavodnik->jmeno }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-sm">{{ $zavodnik->prijmeni }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-sm">{{ $zavodnik->datum_narozeni }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-sm">{{ $zavodnik->body_celkem }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-sm">
                                    <a href="{{ route('zavody.ulovky', [$zavodnik->id, $zavod->id]) }}" class="text-white">
                                        <x-button>Úlovky</x-button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Karty pro mobilní zařízení (skrytá na desktopu) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 md:hidden">
                @foreach ($zavodnici as $zavodnik)
                    <div class="bg-white p-6 border border-gray-300 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                        <h3 class="text-xl font-semibold text-gray-800">{{ $zavodnik->jmeno }} {{ $zavodnik->prijmeni }}</h3>
                        <p class="text-red-400">Umístění: {{ $zavodnik->umisteni }}</p>
                        <p class="text-gray-600">Datum narození: {{ $zavodnik->datum_narozeni }}</p>
                        <p class="text-gray-600">Body: {{ $zavodnik->body_celkem }}</p>

                        <div class="mt-4">
                            <a href="{{ route('zavody.ulovky', [$zavodnik->id, $zavod->id]) }}" >
                                <x-button>Úlovky</x-button>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>

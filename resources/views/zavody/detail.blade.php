<x-app-layout>
    <div class="max-w-6xl mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
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
            <a href="{{ route('zavody.pridatZavodnika', $zavod->id) }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-black font-semibold py-2 px-4 rounded-lg">
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
            <div class="overflow-x-auto">
                <table class="min-w-full border-collapse border border-gray-300">
                    <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2 text-left">Umístění</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Jméno</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Příjmení</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Datum narození</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Body</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($zavodnici as $zavodnik)
                        <tr class="hover:bg-gray-50">
                            <td class="border border-gray-300 px-4 py-2">{{ $zavodnik->umisteni }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $zavodnik->jmeno }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $zavodnik->prijmeni }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $zavodnik->datum_narozeni }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $zavodnik->body_celkem }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>

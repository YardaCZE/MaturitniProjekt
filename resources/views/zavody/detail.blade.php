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
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach ($zavodnici as $zavodnik)
                    <div class="bg-white p-6 border border-gray-300 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                        <h3 class="text-xl font-semibold text-gray-800">{{ $zavodnik->jmeno }} {{ $zavodnik->prijmeni }}</h3>
                        <p class="text-gray-600">Umístění: {{ $zavodnik->umisteni }}</p>
                        <p class="text-gray-600">Datum narození: {{ $zavodnik->datum_narozeni }}</p>
                        <p class="text-gray-600">Body: {{ $zavodnik->body_celkem }}</p>

                        <div class="mt-4">
                            <a href="{{ route('zavody.ulovky', [$zavodnik->id, $zavod->id]) }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg">
                                <x-button>Úlovky</x-button>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>

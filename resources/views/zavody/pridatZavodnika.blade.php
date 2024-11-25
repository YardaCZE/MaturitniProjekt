<x-app-layout>
    <div class="max-w-4xl mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
        {{-- Zobrazení zprávy o úspěchu --}}
        @if (session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline font-medium">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Zobrazení chybových hlášení --}}
        @if ($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Nadpis --}}
        <h1 class="text-2xl font-semibold text-gray-800 mb-6">
            Přidat závodníka do závodu: <span class="text-blue-500">{{ $zavod->nazev }}</span>
        </h1>

        {{-- Formulář --}}
        <form action="{{ route('zavody.storeZavodnik', $zavod->id) }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="jmeno" class="block text-sm font-medium text-gray-700">Jméno</label>
                <input type="text" name="jmeno" id="jmeno" value="{{ old('jmeno') }}"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label for="prijmeni" class="block text-sm font-medium text-gray-700">Příjmení</label>
                <input type="text" name="prijmeni" id="prijmeni" value="{{ old('prijmeni') }}"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label for="narozeni" class="block text-sm font-medium text-gray-700">Datum narození</label>
                <input type="date" name="narozeni" id="narozeni" value="{{ old('narozeni') }}"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <x-button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg">
                Přidat závodníka
            </x-button>
        </form>

        <a href="{{ route('zavody.detail', $zavod->id) }}" class="text-white">
            <x-button>
                zpět na přehled
            </x-button>
        </a>
    </div>
</x-app-layout>

<x-app-layout>
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline font-semibold">{{ session('success') }}</span>
        </div>
    @endif

    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Přidat pozorovatele pro závod: <span
                class="text-indigo-600">{{ $zavod->nazev }}</span></h1>

        <form action="{{ route('zavody.storePozorovatel', $zavod->id) }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="user_id" class="block text-gray-700 font-medium mb-2">Vyberte uživatele</label>
                <select name="user_id" id="user_id" required
                        class="select2 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="" disabled selected>--Vyberte uživatele--</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->email }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <x-button type="submit">Přidat měřiče</x-button>
            </div>
        </form>

        <div class="mt-8">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Seznam měřičů pro závod: <span
                    class="text-indigo-600">{{ $zavod->nazev }}</span></h2>
            <ul class="list-disc list-inside space-y-2">
                @forelse($zavod->pozorovatele as $pozorovatel)
                    <li class="text-gray-700">{{ $pozorovatel->uzivatel->name }}
                        - {{ $pozorovatel->uzivatel->email ?? 'Neznámý uživatel' }}</li>
                @empty
                    <p class="text-gray-500">Žádní pozorovatelé zatím nebyli přidáni.</p>
                @endforelse
            </ul>
        </div>
        <a href="{{ route('zavody.detail', $zavod->id) }}" class="text-white">
            <x-button>
                zpět na přehled
            </x-button>
        </a>
    </div>
</x-app-layout>

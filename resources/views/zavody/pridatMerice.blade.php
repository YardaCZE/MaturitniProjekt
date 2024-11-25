<x-app-layout>
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <h1>Přidat měřiče pro závod: {{ $zavod->nazev }}</h1>

    <form action="{{ route('zavody.storeMeric', $zavod->id) }}" method="POST">
        @csrf

        <div>
            <label for="user_id">Vyberte uživatele</label>
            <select name="user_id" id="user_id" required>
                <option value="">--Vyberte uživatele--</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <x-button type="submit">Přidat měřiče</x-button>
    </form>

        <h2>Seznam měřičů pro závod: {{ $zavod->nazev }}</h2>
        <ul>
            @foreach($zavod->merici as $meric)
                <li>{{ $meric->uzivatel->name ?? 'Neznámý uživatel' }}</li> <!-- Ošetření nulového uživatele -->
            @endforeach
        </ul>

</x-app-layout>

<x-app-layout>
<h1 class="text-2xl font-semibold text-gray-800 leading-tight">Přihlásit se do soukromé skupiny</h1>

<form action="{{ route('skupiny.prihlasit') }}" method="POST">
    @csrf
    <label for="nazev_skupiny">Název skupiny:</label>
    <input type="text" name="nazev_skupiny" required>

    <label for="heslo">Heslo:</label>
    <input type="password" name="heslo" required>

    <x-button>Přihlásit se</x-button>
</form>
    </x-app-layout>

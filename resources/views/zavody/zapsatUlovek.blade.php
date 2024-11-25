<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Zapsat úlovek
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-10">
        @if ($errors->any())
            <div class="bg-red-500 text-white rounded p-4 mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('ulovek.store', $id) }}">
            @csrf
            <div class="mb-4">
                <label for="id_zavodnika" class="block text-gray-700">Vyber závodníka:</label>
                <select name="id_zavodnika" id="id_zavodnika" class="border rounded w-full py-2 px-3">
                    @foreach($zavodnici as $zavodnik)
                        <option value="{{ $zavodnik->id }}">
                            {{ $zavodnik->jmeno }} {{ $zavodnik->prijmeni }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="druh_ryby" class="block text-gray-700">Druh ryby:</label>
                <input type="text" name="druh_ryby" id="druh_ryby" class="border rounded w-full py-2 px-3" required>
            </div>

            <div class="mb-4">
                <label for="delka" class="block text-gray-700">Délka (cm):</label>
                <input type="number" name="delka" id="delka" class="border rounded w-full py-2 px-3">
            </div>

            <div class="mb-4">
                <label for="vaha" class="block text-gray-700">Váha (kg):</label>
                <input type="number" name="vaha" id="vaha" class="border rounded w-full py-2 px-3">
            </div>

            <div class="mb-4">
                <label for="body" class="block text-gray-700">Body:</label>
                <input type="number" name="body" id="body" class="border rounded w-full py-2 px-3" required>
            </div>

            <div>
                <x-button type="submit" class="bg-blue-500 text-white rounded py-2 px-4 hover:bg-blue-700">
                    Zapsat úlovek
                </x-button>
            </div>
        </form>
    </div>
</x-app-layout>

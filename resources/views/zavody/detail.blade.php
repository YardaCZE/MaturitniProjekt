<x-app-layout>
    <h1>Závod {{ $zavod->nazev }}</h1>
    <a href="{{ route('zavody.pridatZavodnika', $zavod->id) }}" class="text-white">
        <x-button>
            Přidat účastníka
        </x-button>
    </a>
</x-app-layout>

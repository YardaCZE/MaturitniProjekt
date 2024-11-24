<x-app-layout>
    <div class="container mx-auto px-6 py-8">

        <div class="flex justify-end mb-6">
            <a href="{{ route('zavody.create') }}">
                <x-button class="bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-5 rounded-lg shadow-lg transition duration-200 ease-in-out">
                    Nový závod
                </x-button>
            </a>
        </div>

        <h2 class="text-lg font-semibold text-gray-800 mb-4">Moje závody</h2>

        @if($uzivatelovoZavody->isEmpty())
            <p class="text-gray-500">neni zaznam</p>
        @else
            <ul>
                @foreach($uzivatelovoZavody as $zavod)
                    <li>{{ $zavod->nazev }}</li>
                @endforeach
            </ul>
        @endif

        <!--čára-->
        <hr class="my-8 border-gray-300">

        <h2 class="text-lg font-semibold text-gray-800 mb-4">Všechny veřejné závody</h2>

        @if($verejneZavody->isEmpty())
            <p class="text-gray-500">neni zaznam</p>
        @else
            <ul>
                @foreach($verejneZavody as $zavod)
                    <li>{{ $zavod->nazev }}</li>
                @endforeach
            </ul>
        @endif

    </div>
</x-app-layout>

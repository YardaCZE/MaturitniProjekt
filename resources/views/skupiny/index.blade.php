<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <h1 class="font-semibold text-xl text-gray-800 leading-tight">Seznam Skupin</h1>

                <x-button><a href="{{ route('skupiny.create') }}">Vytvořit skupinu</a></x-button>
                <x-button><a href="{{ route('skupiny.prihlasit-se') }}">Přihlásit se do soukromé skupiny</a></x-button>



                <ul>
                    @foreach($skupiny as $skupina)
                        <li>
                            {{ $skupina->nazev_skupiny }}
                            <a href="{{ route('skupiny.show', $skupina->id) }}">Otevřít skupinu</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

</x-app-layout>


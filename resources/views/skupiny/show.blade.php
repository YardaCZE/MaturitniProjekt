<x-app-layout>

    <a href="{{ route('prispevky.create', ['skupina_id' => $skupina->id]) }}">
        <x-button>
            Vytvořit nový příspěvek
        </x-button>
    </a>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <h1 class="text-2xl font-semibold text-gray-800 leading-tight">{{ $skupina->nazev_skupiny }}</h1>

            <h2 class="text-3xl font-semibold text-gray-800 leading-tight">Příspěvky ve skupině</h2>
            <ul>
                @foreach($prispevky as $prispevek)
                    <li>
                        <strong>{{ $prispevek->nadpis }}</strong><br>
                        {{ $prispevek->text }}<br>
                    </li>
                @endforeach
            </ul>

<a href="{{ route('skupiny.index') }}">
    <x-button>
        Zpět na seznam skupin
    </x-button>
</a>

            </div>
        </div>
    </div>
    </x-app-layout>

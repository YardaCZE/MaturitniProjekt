<x-app-layout>

    <a href="{{ route('prispevky.create', ['skupina_id' => $skupina->id]) }}">
        <x-button>
            Vytvořit nový příspěvek
        </x-button>
    </a>

    @if(auth()->user()->isAdmin() || auth()->user()->id === $skupina->id_admin)
        <a href="{{ route('pozvanky.admin', ['id' => $skupina->id]) }}">
            <x-button>
                Admin panel
            </x-button>
        </a>
    @endif

    <a href="{{ route('lokality.skupinaLokality', ['skupina_id' => $skupina->id]) }}">
        <x-button>
            Soukromé lokality
        </x-button>
    </a>

    <a href="{{ route('ulovky.SkupinaUlovky', ['skupina_id' => $skupina->id]) }}">
        <x-button>
            Soukromé úlovky
        </x-button>
    </a>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <h1 class="text-2xl font-semibold text-gray-800 leading-tight">{{ $skupina->nazev_skupiny }}</h1>

            <h2 class="text-3xl font-semibold text-gray-800 leading-tight">Příspěvky ve skupině</h2>
            <ul>
                @foreach($prispevky as $prispevek)
                    <li class="py-4 flex justify-between items-center">
                        <div class="text-lg font-medium text-gray-900">{{ $prispevek->nadpis }}</div>
                        <a href="{{ route('prispevky.detail', $prispevek->id) }}" class="text-white">
                            <x-button>
                                Detail příspěvku
                            </x-button>
                        </a>

                        @if(auth()->user()->isAdmin() || auth()->user()->id === $prispevek->id_autora || $jeModerator)
                            <form action="{{ route('prispevky.destroy', $prispevek->id) }}" method="POST" onsubmit="return confirm('Opravdu chcete tento příspěvek smazat?');">
                                @csrf
                                @method('DELETE')
                                <x-button class="bg-red-600 hover:bg-red-700">Smazat</x-button>
                            </form>
                        @endif

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

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg p-8">
                <div class="mb-6 text-center">
                    <h1 class="text-4xl font-bold text-gray-800 mb-2">{{ $skupina->nazev_skupiny }}</h1>
                </div>

                <div class="flex justify-center gap-4 mb-8">
                    <a href="{{ route('prispevky.create', ['skupina_id' => $skupina->id]) }}">
                        <x-button class="bg-green-600 hover:bg-green-700">
                             Vytvořit nový příspěvek
                        </x-button>
                    </a>

                    <a href="{{ route('lokality.skupinaLokality', ['skupina_id' => $skupina->id]) }}">
                        <x-button class="bg-primarni hover:bg-primarniDarker">
                             Soukromé lokality
                        </x-button>
                    </a>

                    <a href="{{ route('ulovky.SkupinaUlovky', ['skupina_id' => $skupina->id]) }}">
                        <x-button class="bg-primarni hover:bg-primarniDarker">
                             Soukromé úlovky
                        </x-button>
                    </a>

                    @if(auth()->user()->isAdmin() || auth()->user()->id === $skupina->id_admin)
                        <a href="{{ route('pozvanky.admin', ['id' => $skupina->id]) }}">
                            <x-button class="bg-primarni hover:bg-primarniDarker">
                                ⚙ Admin panel
                            </x-button>
                        </a>
                    @endif
                </div>

                <div class="mb-10">
                    <h2 class="text-3xl font-semibold text-gray-800 mb-4"> Příspěvky ve skupině</h2>
                    <ul class="divide-y divide-gray-200">
                        @foreach($prispevky as $prispevek)
                            <li class="py-4 flex justify-between items-center">
                                <div>
                                    <h3 class="text-xl font-medium text-gray-900">{{ $prispevek->nadpis }}</h3>
                                    <p class="text-sm text-gray-500">Přidal/a: {{ $prispevek->autor->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $prispevek->created_at->format('d.m.Y H:i')}}</p>
                                </div>

                                <div class="flex items-center gap-4">
                                    <a href="{{ route('prispevky.detail', $prispevek->id) }}">
                                        <x-button class="bg-primarni hover:bg-primarniDarker">
                                             Detail příspěvku
                                        </x-button>
                                    </a>

                                    @if(auth()->user()->isAdmin() || auth()->user()->id === $prispevek->id_autora || $jeModerator)
                                        <form action="{{ route('prispevky.destroy', $prispevek->id) }}" method="POST" onsubmit="return confirm('Opravdu chcete tento příspěvek smazat?');">
                                            @csrf
                                            @method('DELETE')
                                            <x-button class="bg-pozor hover:bg-red-700">
                                                 Smazat
                                            </x-button>
                                        </form>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="text-center mt-10">
                    <a href="{{ route('skupiny.index') }}">
                        <x-button class="bg-primarni hover:bg-primarniDarker">
                            Zpět na seznam skupin
                        </x-button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

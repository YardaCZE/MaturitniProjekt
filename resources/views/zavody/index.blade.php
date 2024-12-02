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
                    <li class="py-4 flex justify-between items-center">
                        <div class="text-lg font-medium text-gray-900">{{ $zavod->nazev }}</div>
                        <a href="{{ route('zavody.detail', $zavod->id) }}" class="text-white">
                            <x-button>
                                zobrazit
                            </x-button>
                        </a>
                        @if(auth()->user()->isAdmin() || auth()->user()->id === $zavod->id_zakladatele)
                            <form action="{{ route('zavody.destroy', $zavod->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <x-button type="submit" class="bg-red-600 hover:bg-red-600 text-white font-semibold py-1 px-3 rounded-md shadow transition duration-200 ease-in-out" onclick="return confirm('Opravu chcete smazat tento závod?');">
                                    Smazat
                                </x-button>
                            </form>
                        @endif
                    </li>
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
                    <li class="py-4 flex justify-between items-center">
                        <div class="text-lg font-medium text-gray-900">{{ $zavod->nazev }}</div>
                        <a href="{{ route('zavody.detail', $zavod->id) }}" class="text-white">
                            <x-button>
                                zobrazit
                            </x-button>
                        </a>
                        @if(auth()->user()->isAdmin() || auth()->user()->id === $zavod->id_zakladatele)
                            <form action="{{ route('zavody.destroy', $zavod->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <x-button type="submit" class="bg-red-600 hover:bg-red-600 text-white font-semibold py-1 px-3 rounded-md shadow transition duration-200 ease-in-out" onclick="return confirm('Opravu chcete smazat tento závod?');">
                                    Smazat
                                </x-button>
                            </form>
                        @endif
                    </li>

                @endforeach
            </ul>
        @endif

    </div>
</x-app-layout>

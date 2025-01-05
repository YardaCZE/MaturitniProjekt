<x-app-layout>
    <div class="container mx-auto px-6 py-8">

        <div class="flex justify-end mb-6">
            <a href="{{ route('zavody.create') }}">
                <button class="bg-primarni hover:bg-primarniDarker text-white font-semibold py-3 px-5 rounded-lg shadow-lg transition duration-200 ease-in-out">
                    Nový závod
                </button>
            </a>
        </div>

        <h2 class="text-2xl font-bold text-[#1F4529] mb-6">Moje závody</h2>

        @if($uzivatelovoZavody->isEmpty())
            <div class="bg-primarni p-6 rounded-lg shadow-md text-center">
                <p class="text-[#47663B] text-lg font-medium">Žádný závod nenalezen</p>
            </div>
        @else
            <ul class="divide-y divide-[#E8ECD7]">
                @foreach($uzivatelovoZavody as $zavod)
                    <li class="py-4 flex justify-between items-center bg-sekundarni px-4 rounded-lg shadow-md mb-4">
                        <div class="text-xl font-medium text-white">{{ $zavod->nazev }}</div>
                        <div class="flex space-x-3">
                            <a href="{{ route('zavody.detail', $zavod->id) }}">
                                <button class="bg-primarni hover:bg-[#1F4529] text-[#E8ECD7] font-medium py-2 px-4 rounded-md shadow">
                                    Zobrazit
                                </button>
                            </a>
                            @if(auth()->user()->isAdmin() || auth()->user()->id === $zavod->id_zakladatele)
                                <form action="{{ route('zavody.destroy', $zavod->id) }}" method="POST" onsubmit="return confirm('Opravdu chcete smazat tento závod?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-pozor hover:bg-red-700 text-white font-medium py-2 px-4 rounded-md shadow">
                                        Smazat
                                    </button>
                                </form>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif

        <hr class="my-12 border-[#E8ECD7]">

        <h2 class="text-2xl font-bold text-[#1F4529] mb-6">Všechny veřejné závody</h2>

        @if($verejneZavody->isEmpty())
            <div class="bg-[#E8ECD7] p-6 rounded-lg shadow-md text-center">
                <p class="text-[#47663B] text-lg font-medium">Žádný závod nenalezen</p>
            </div>
        @else
            <ul class="divide-y divide-[#E8ECD7]">
                @foreach($verejneZavody as $zavod)
                    <li class="py-4 flex justify-between items-center bg-sekundarni px-4 rounded-lg shadow-md mb-4">
                        <div class="text-xl font-medium text-white">{{ $zavod->nazev }}</div>
                        <div class="flex space-x-3">
                            <a href="{{ route('zavody.detail', $zavod->id) }}">
                                <button class="bg-primarni hover:bg-primarniDarker text-white font-medium py-2 px-4 rounded-md shadow">
                                    Zobrazit
                                </button>
                            </a>
                            @if(auth()->user()->isAdmin() || auth()->user()->id === $zavod->id_zakladatele)
                                <form action="{{ route('zavody.destroy', $zavod->id) }}" method="POST" onsubmit="return confirm('Opravdu chcete smazat tento závod?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-pozor hover:bg-red-700 text-white font-medium py-2 px-4 rounded-md shadow">
                                        Smazat
                                    </button>
                                </form>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif

    </div>
</x-app-layout>

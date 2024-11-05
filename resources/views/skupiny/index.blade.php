<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex space-x-4 my-4">
                    <a href="{{ route('skupiny.create') }}">
                        <x-button class="bg-blue-600 hover:bg-blue-700">Vytvořit skupinu</x-button>
                    </a>
                    <a href="{{ route('skupiny.prihlasit-se') }}">
                        <x-button class="bg-green-600 hover:bg-green-700">Přihlásit se do soukromé skupiny</x-button>
                    </a>
                </div>



                <h2 class="text-2xl font-bold mt-8 mb-4 text-gray-800">Moje soukromé skupiny</h2>
                <ul class="divide-y divide-gray-200">
                    @foreach($soukromeSkupiny as $skupina)
                        <li class="py-4 flex justify-between items-center hover:bg-gray-100 transition duration-200">
                            <div>
                                <div class="text-lg font-medium text-gray-900">{{ $skupina->nazev_skupiny }}</div>
                                <div class="text-sm text-gray-500">Autor: {{ $skupina->admin->name ?? 'Neznámý' }}</div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('skupiny.show', $skupina->id) }}">
                                  <x-button class="bg-indigo-600 hover:bg-indigo-700">Otevřít skupinu</x-button>
                                </a>
                                @if(auth()->user()->isAdmin() || auth()->user()->id === $skupina->id_admin)
                                    <form action="{{ route('skupiny.destroy', $skupina->id) }}" method="POST" onsubmit="return confirm('Opravdu chcete tuto skupinu smazat?');">
                                        @csrf
                                        @method('DELETE')
                                        <x-button class="bg-red-600 hover:bg-red-700">Smazat</x-button>
                                    </form>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>


                <!--čárka-->
                <hr class="my-8 border-gray-300" />

                <h2 class="text-2xl font-bold mt-8 mb-4 text-gray-800">Veřejné skupiny</h2>
                <ul class="divide-y divide-gray-200">
                    @foreach($verejneSkupiny as $skupina)
                        <li class="py-4 flex justify-between items-center hover:bg-gray-100 transition duration-200">
                            <div>
                                <div class="text-lg font-medium text-gray-900">{{ $skupina->nazev_skupiny }}</div>
                                <div class="text-sm text-gray-500">Autor: {{ $skupina->admin->name ?? 'Neznámý' }}</div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('skupiny.show', $skupina->id) }}">
                                    <x-button class="bg-indigo-600 hover:bg-indigo-700">Otevřít skupinu</x-button>
                                </a>
                                @if(auth()->user()->isAdmin() || auth()->user()->id === $skupina->id_admin)
                                    <form action="{{ route('skupiny.destroy', $skupina->id) }}" method="POST" onsubmit="return confirm('Opravdu chcete tuto skupinu smazat?');">
                                        @csrf
                                        @method('DELETE')
                                        <x-button class="bg-red-600 hover:bg-red-700">Smazat</x-button>
                                    </form>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>




            </div>
        </div>
    </div>
</x-app-layout>

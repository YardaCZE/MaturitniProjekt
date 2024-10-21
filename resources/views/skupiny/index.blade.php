<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- Section Title -->
                <div class="mb-6">
                    <h1 class="text-2xl font-semibold text-gray-800 leading-tight">Seznam Skupin</h1>
                    <p class="text-gray-600">Prohlédněte si dostupné veřejné skupiny nebo se přihlašte do soukromé skupiny.</p>
                </div>

                <!-- Action Buttons -->
                <div class="flex space-x-4 my-4">
                  <a href="{{ route('skupiny.create') }}" class="text-white">
                    <x-button>Vytvořit skupinu</x-button>
                  </a>

                    <a href="{{ route('skupiny.prihlasit-se') }}" class="text-white">
                    <x-button>
                        Přihlásit se do soukromé skupiny
                    </x-button>
                    </a>
                </div>

                <!-- Groups List -->
                <ul class="divide-y divide-gray-200">
                    @foreach($skupiny as $skupina)
                        <li class="py-4 flex justify-between items-center">
                            <div class="text-lg font-medium text-gray-900">{{ $skupina->nazev_skupiny }}</div>
                            <a href="{{ route('skupiny.show', $skupina->id) }}" class="text-white">
                                <x-button>
                                    Otevřít skupinu
                                </x-button>


                                @if(auth()->user()->isAdmin() || auth()->user()->id === $skupina->id_admin)
                                    <form action="{{ route('skupiny.destroy', $skupina->id) }}" method="POST" onsubmit="return confirm('Opravdu chcete tuto skupinu smazat?');">
                                        @csrf
                                        @method('DELETE')
                                        <x-button class="bg-red-600 hover:bg-red-700">Smazat</x-button>
                                    </form>
                            @endif

                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>

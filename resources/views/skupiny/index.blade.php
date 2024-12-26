<x-app-layout>
    <style>
        .header-bg {
            background-image: url('https://images.unsplash.com/photo-1469903130378-57b1170cf901?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }
    </style>

    <div class="header-bg text-white rounded-lg shadow-lg p-6 mb-6">
        <h1 class="text-4xl font-bold ">Seznam skupin</h1>
        <p class="text-lg ">Připojte se k veřejným skupinám, nebo spravujte své vlastní!</p>
    </div>

    <div class="container mx-auto px-6 py-8 bg-gray-50 min-h-screen">
        <!-- Akce -->
        <div class="flex justify-end mb-6 space-x-4">
            <a href="{{ route('skupiny.create') }}">
                <x-button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-5 rounded-lg shadow-lg">
                    ➕ Vytvořit skupinu
                </x-button>
            </a>
            <a href="{{ route('skupiny.prihlasit-se') }}">
                <x-button class="bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-5 rounded-lg shadow-lg">
                    🔑 Přihlásit se do soukromé skupiny
                </x-button>
            </a>
        </div>

        <!-- Soukromé skupiny -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Moje soukromé skupiny</h2>
            <ul class="divide-y divide-gray-200 bg-white rounded-lg shadow-lg">
                @forelse($soukromeSkupiny as $skupina)
                    <li class="py-6 px-4 flex justify-between items-center card">
                        <div>
                            <div class="text-lg font-semibold text-gray-900">{{ $skupina->nazev_skupiny }}</div>
                            <div class="text-sm text-gray-500">Autor: {{ $skupina->admin->name ?? 'Neznámý' }}</div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('skupiny.show', $skupina->id) }}"
                               class="bg-indigo-600 text-white px-3 py-2 rounded-lg hover:bg-indigo-700 shadow">Otevřít</a>

                            @if(!$skupina->jeClen(auth()->id()) && auth()->id() !== $skupina->id_admin)
                                <form action="{{ route('skupiny.pripojit', $skupina->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-green-600 text-white px-3 py-2 rounded-lg hover:bg-green-700 shadow">Připojit</button>
                                </form>
                            @endif

                            @if(auth()->user()->isAdmin() || auth()->id() === $skupina->id_admin)
                                <form action="{{ route('skupiny.destroy', $skupina->id) }}" method="POST"
                                      onsubmit="return confirm('Opravdu chcete tuto skupinu smazat?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 text-white px-3 py-2 rounded-lg hover:bg-red-700 shadow">Smazat</button>
                                </form>
                            @endif
                        </div>
                    </li>
                @empty
                    <li class="py-4 px-4 text-gray-500">Nemáte žádné soukromé skupiny.</li>
                @endforelse
            </ul>
        </div>

        <!-- Veřejné skupiny -->
        <div>
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Veřejné skupiny</h2>
            <ul class="divide-y divide-gray-200 bg-white rounded-lg shadow-lg">
                @forelse($verejneSkupiny as $skupina)
                    <li class="py-6 px-4 flex justify-between items-center card">
                        <div>
                            <div class="text-lg font-semibold text-gray-900">{{ $skupina->nazev_skupiny }}</div>
                            <div class="text-sm text-gray-500">Autor: {{ $skupina->admin->name ?? 'Neznámý' }}</div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('skupiny.show', $skupina->id) }}"
                               class="bg-indigo-600 text-white px-3 py-2 rounded-lg hover:bg-indigo-700 shadow">Otevřít</a>

                            @if(!$skupina->jeClen(auth()->id()))
                                <form action="{{ route('skupiny.pripojit', $skupina->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-green-600 text-white px-3 py-2 rounded-lg hover:bg-green-700 shadow">Připojit</button>
                                </form>
                            @else
                                <form action="{{ route('skupiny.opustit', $skupina->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-yellow-600 text-white px-3 py-2 rounded-lg hover:bg-yellow-700 shadow">Odejít</button>
                                </form>
                            @endif


                        @if(auth()->user()->isAdmin() || auth()->id() === $skupina->id_admin)
                                <form action="{{ route('skupiny.destroy', $skupina->id) }}" method="POST"
                                      onsubmit="return confirm('Opravdu chcete tuto skupinu smazat?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 text-white px-3 py-2 rounded-lg hover:bg-red-700 shadow">Smazat</button>
                                </form>
                            @endif
                        </div>
                    </li>
                @empty
                    <li class="py-4 px-4 text-gray-500">Nemáte žádné veřejné skupiny.</li>
                @endforelse
            </ul>
        </div>
    </div>
</x-app-layout>

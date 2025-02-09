<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Sekce uložených lokalit -->
            <div class="bg-white rounded-lg shadow-sm mb-8">
                <div class="border-b border-gray-200 p-6">
                    <h1 class="text-2xl font-bold text-gray-900">Uložené lokality</h1>
                </div>

                <div class="p-6">
                    @if ($ulozeneLokality->isEmpty())
                        <div class="text-center py-8">
                            <p class="text-gray-500">Nemáte žádné uložené lokality.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Název</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Druh</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rozloha</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kraj</th>

                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Akce</th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($ulozeneLokality as $lokalita)
                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $lokalita->nazev_lokality }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $lokalita->druh }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $lokalita->rozloha }} ha
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $lokalita->kraj }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-center space-x-2">
                                                <a href="{{ route('lokality.detail', $lokalita->id) }}"
                                                   class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-200">
                                                    Detail
                                                </a>

                                                @if(auth()->user()->isAdmin() || auth()->user()->id === $lokalita->id_zakladatele)
                                                    <form action="{{ route('lokality.destroy', $lokalita->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 transition-colors duration-200"
                                                                onclick="return confirm('Opravdu chcete smazat tuto lokalitu?');">
                                                            Smazat
                                                        </button>
                                                    </form>
                                                @endif

                                                <form action="{{ route('lokality.save', $lokalita->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                            class="inline-flex items-center px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                                                        @if ($lokalita->saves()->where('user_id', auth()->id())->exists())
                                                            <span class="text-green-500">✅ Uloženo</span>
                                                        @else
                                                            <span>➕ Uložit</span>
                                                        @endif
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sekce úlovků -->
            <div class="bg-white rounded-lg shadow-sm">
                <div class="border-b border-gray-200 p-6">
                    <h2 class="text-2xl font-bold text-gray-900">Úlovky</h2>
                </div>

                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Autor</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Délka</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Váha</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Druh ryby</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokalita</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Typ lovu</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Akce</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($ulozeneUlovky as $ulovek)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $ulovek->uzivatel->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $ulovek->delka }} cm
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $ulovek->vaha }} kg
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $ulovek->druh_ryby }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $ulovek->lokalita->nazev_lokality ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $ulovek->typLovu->druh ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex justify-center space-x-2">
                                            <a href="{{ route('ulovky.detail', $ulovek->id) }}"
                                               class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-200">
                                                Detail
                                            </a>

                                            @if(auth()->user()->isAdmin() || auth()->user()->id === $ulovek->id_uzivatele)
                                                <form action="{{ route('ulovky.destroy', $ulovek->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 transition-colors duration-200"
                                                            onclick="return confirm('Opravdu chcete smazat tento úlovek?')">
                                                        Smazat
                                                    </button>
                                                </form>
                                            @endif

                                            <div class="flex items-center space-x-1">
                                                <form action="{{ route('ulovky.like', $ulovek->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                            class="inline-flex items-center px-2 py-1 border border-gray-300 rounded-md bg-white hover:bg-gray-50 transition-colors duration-200">
                                                        @if($ulovek->likes()->where('user_id', auth()->id())->exists())
                                                            <span class="text-red-500">❤️</span>
                                                        @else
                                                            <span>🤍</span>
                                                        @endif
                                                        <span class="ml-1 text-sm text-gray-500">{{ $ulovek->likeCount() }}</span>
                                                    </button>
                                                </form>

                                                <form action="{{ route('ulovky.save', $ulovek->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                            class="inline-flex items-center px-2 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                                                        @if ($ulovek->saves()->where('user_id', auth()->id())->exists())
                                                            <span class="text-green-500">✅ Uloženo</span>
                                                        @else
                                                            <span>➕ Uložit</span>
                                                        @endif
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Tlačítko pro vytvoření lokality -->
            <div class="flex justify-end mb-8">
                <a href="{{ route('lokality.create') }}">
                    <x-button class="bg-primarni hover:bg-primarniDarker text-white font-semibold py-3 px-6 rounded-lg shadow-lg transition duration-200 ease-in-out flex items-center">
                        <span class="mr-2">+</span> Vytvořit lokalitu
                    </x-button>
                </a>
            </div>

            @if($uzivatelovolokality->isNotEmpty())
                <!-- Sekce moje lokality -->
                <div class="bg-white rounded-lg shadow-sm mb-8">
                    <div class="border-b border-gray-200 p-6">
                        <h2 class="text-xl font-bold text-gray-900">Moje lokality</h2>
                    </div>

                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Název lokality</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Druh</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rozloha</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokace</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Akce</th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($uzivatelovolokality as $lokalita)
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

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex justify-center space-x-2">
                                                <a href="{{ route('lokality.detail', $lokalita->id) }}"
                                                   class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-primarni hover:bg-primarniDarker transition-colors duration-200">
                                                    Detail
                                                </a>

                                                @if(auth()->user()->isAdmin())
                                                    <form action="{{ route('lokality.destroy', $lokalita->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-pozor hover:bg-red-700 transition-colors duration-200"
                                                                onclick="return confirm('Opravdu chcete tuto lokalitu smazat?')">
                                                            Smazat
                                                        </button>
                                                    </form>
                                                @endif

                                                <div class="flex items-center space-x-1">
                                                    <form action="{{ route('lokality.like', $lokalita->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit"
                                                                class="inline-flex items-center px-2 py-1 border border-gray-300 rounded-md bg-white hover:bg-gray-50 transition-colors duration-200">
                                                            @if($lokalita->likes()->where('user_id', auth()->id())->exists())
                                                                <span class="text-red-500">❤️</span>
                                                            @else
                                                                <span>🤍</span>
                                                            @endif
                                                            <span class="ml-1 text-sm text-gray-500">{{ $lokalita->likeCount() }}</span>
                                                        </button>
                                                    </form>

                                                    <form action="{{ route('lokality.save', $lokalita->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit"
                                                                class="inline-flex items-center px-2 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                                                            @if ($lokalita->saves()->where('user_id', auth()->id())->exists())
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
                        <div class="mt-4">
                            {{ $uzivatelovolokality->links() }}
                        </div>
                    </div>
                </div>

                <hr class="my-8 border-gray-200">
            @endif

            <!-- Sekce veřejné lokality -->
            <div class="bg-white rounded-lg shadow-sm">
                <div class="border-b border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-900">Veřejné lokality</h2>
                </div>

                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Název lokality</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Druh</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rozloha</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokace</th>

                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Akce</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($verejneLokality as $lokalita)
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
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex justify-center space-x-2">
                                            <a href="{{ route('lokality.detail', $lokalita->id) }}"
                                               class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-primarni hover:bg-primarniDarker transition-colors duration-200">
                                                Detail
                                            </a>

                                            @if(auth()->user()->isAdmin())
                                                <form action="{{ route('lokality.destroy', $lokalita->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-pozor hover:bg-red-700 transition-colors duration-200"
                                                            onclick="return confirm('Opravdu chcete tuto lokalitu smazat?')">
                                                        Smazat
                                                    </button>
                                                </form>
                                            @endif

                                            <div class="flex items-center space-x-1">
                                                <form action="{{ route('lokality.like', $lokalita->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                            class="inline-flex items-center px-2 py-1 border border-gray-300 rounded-md bg-white hover:bg-gray-50 transition-colors duration-200">
                                                        @if($lokalita->likes()->where('user_id', auth()->id())->exists())
                                                            <span class="text-red-500">❤️</span>
                                                        @else
                                                            <span>🤍</span>
                                                        @endif
                                                        <span class="ml-1 text-sm text-gray-500">{{ $lokalita->likeCount() }}</span>
                                                    </button>
                                                </form>

                                                <form action="{{ route('lokality.save', $lokalita->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                            class="inline-flex items-center px-2 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                                                        @if ($lokalita->saves()->where('user_id', auth()->id())->exists())
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
                    <div class="mt-4">
                        {{ $verejneLokality->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

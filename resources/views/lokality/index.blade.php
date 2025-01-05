<x-app-layout>
    <div class="container mx-auto px-6 py-8">
        <div class="flex justify-end mb-6">
            <a href="{{ route('lokality.create') }}">
                <x-button class="bg-primarni hover:bg-primarniDarker text-white font-semibold py-3 px-5 rounded-lg shadow-lg transition duration-200 ease-in-out">
                    Vytvořit lokalitu
                </x-button>
            </a>
        </div>

@if($uzivatelovolokality->isNotEmpty())
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Moje lokality</h2>
        <div class="overflow-x-auto bg-white rounded-lg shadow-lg mb-8">
            <table class="table-auto w-full border-collapse border border-gray-300">
                <thead class="bg-gray-200 text-gray-700 uppercase text-xs leading-normal">
                <tr>
                    <th class="py-4 px-6 text-left border-b border-gray-300">Název lokality</th>
                    <th class="py-4 px-6 text-left border-b border-gray-300">Druh</th>
                    <th class="py-4 px-6 text-left border-b border-gray-300">Rozloha</th>
                    <th class="py-4 px-6 text-left border-b border-gray-300">Lokace</th>
                    <th class="py-4 px-6 text-left border-b border-gray-300">Souradnice</th>
                    <th class="py-4 px-6 text-center border-b border-gray-300">Akce</th>
                </tr>
                </thead>
                <tbody class="text-gray-800 text-sm">
                @foreach ($uzivatelovolokality as $lokalita)
                    <tr class="hover:bg-gray-100 transition duration-200">
                        <td class="py-3 px-6 border-b border-gray-300">{{ $lokalita->nazev_lokality }}</td>
                        <td class="py-3 px-6 border-b border-gray-300">{{ $lokalita->druh }}</td>
                        <td class="py-3 px-6 border-b border-gray-300">{{ $lokalita->rozloha }} ha</td>
                        <td class="py-3 px-6 border-b border-gray-300">{{ $lokalita->kraj }}</td>
                        <td class="py-3 px-6 border-b border-gray-300">{{ $lokalita->souradnice }}</td>
                        <td class="py-3 px-6 border-b border-gray-300 text-center">
                            <a href="{{ route('lokality.detail', $lokalita->id) }}">
                                <x-button class="bg-primarni hover:bg-primarniDarker text-white font-semibold py-1 px-3 rounded-md shadow transition duration-200 ease-in-out mr-2">
                                    Detail
                                </x-button>
                            </a>

                            @if(auth()->user()->isAdmin())
                                <form action="{{ route('lokality.destroy', $lokalita->id) }}" method="POST"
                                      onsubmit="return confirm('Opravdu chcete tuto loklitu smazat?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-pozor text-white px-3 py-2 rounded-lg hover:bg-red-700 shadow">Smazat</button>
                                </form>
                            @endif
                            <p>{{ $lokalita->likeCount() }} likes</p>
                            <form action="{{ route('lokality.like', $lokalita->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="text-red-500">
                                    @if($lokalita->likes()->where('user_id', auth()->id())->exists())
                                        ❤️
                                    @else
                                        🤍
                                    @endif
                                </button>
                            </form>

                            <form action="{{ route('lokality.save', $lokalita->id) }}" method="POST">
                                @csrf
                                <button type="submit">
                                    @if ($lokalita->saves()->where('user_id', auth()->id())->exists())
                                        ✅ Uloženo
                                    @else
                                        ➕ Uložit
                                    @endif
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $uzivatelovolokality->links() }}
            </div>
        </div>

        <!-- čára -->
        <hr class="my-8 border-gray-300">
        @endif
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Veřejné lokality</h2>
        <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
            <table class="table-auto w-full border-collapse border border-gray-300">
                <thead class="bg-gray-200 text-gray-700 uppercase text-xs leading-normal">
                <tr>
                    <th class="py-4 px-6 text-left border-b border-gray-300">Název lokality</th>
                    <th class="py-4 px-6 text-left border-b border-gray-300">Druh</th>
                    <th class="py-4 px-6 text-left border-b border-gray-300">Rozloha</th>
                    <th class="py-4 px-6 text-left border-b border-gray-300">Lokace</th>
                    <th class="py-4 px-6 text-left border-b border-gray-300">Souradnice</th>
                    <th class="py-4 px-6 text-center border-b border-gray-300">Akce</th>
                </tr>
                </thead>
                <tbody class="text-gray-800 text-sm">
                @foreach ($verejneLokality as $lokalita)
                    <tr class="hover:bg-gray-100 transition duration-200">
                        <td class="py-3 px-6 border-b border-gray-300">{{ $lokalita->nazev_lokality }}</td>
                        <td class="py-3 px-6 border-b border-gray-300">{{ $lokalita->druh }}</td>
                        <td class="py-3 px-6 border-b border-gray-300">{{ $lokalita->rozloha }} ha</td>
                        <td class="py-3 px-6 border-b border-gray-300">{{ $lokalita->kraj }}</td>
                        <td class="py-3 px-6 border-b border-gray-300">{{ $lokalita->souradnice }}</td>
                        <td class="py-3 px-6 border-b border-gray-300 text-center">
                            <a href="{{ route('lokality.detail', $lokalita->id) }}">
                                <x-button class="bg-primarni hover:bg-primarniDarker text-white font-semibold py-1 px-3 rounded-md shadow transition duration-200 ease-in-out mr-2">
                                    Detail
                                </x-button>

                                @if(auth()->user()->isAdmin())
                                    <form action="{{ route('lokality.destroy', $lokalita->id) }}" method="POST"
                                          onsubmit="return confirm('Opravdu chcete tuto loklitu smazat?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-pozor text-white px-3 py-2 rounded-lg hover:bg-red-700 shadow">Smazat</button>
                                    </form>
                                @endif

                                <p>{{ $lokalita->likeCount() }} likes</p>
                                <form action="{{ route('lokality.like', $lokalita->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="text-red-500">
                                        @if($lokalita->likes()->where('user_id', auth()->id())->exists())
                                            ❤️
                                        @else
                                            🤍
                                        @endif
                                    </button>
                                </form>

                                <form action="{{ route('lokality.save', $lokalita->id) }}" method="POST">
                                    @csrf
                                    <button type="submit">
                                        @if ($lokalita->saves()->where('user_id', auth()->id())->exists())
                                            ✅ Uloženo
                                        @else
                                            ➕ Uložit
                                        @endif
                                    </button>
                                </form>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $verejneLokality->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

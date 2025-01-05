<x-app-layout>
    <style>
        .header-bg {
            background-image: url('https://www.sporttroc.com/files/categories/header/23557c54c8c01e80e3ced4036fc499c9.jpg');
            background-size: cover;
            background-position: center;
        }
    </style>

    <div class="header-bg text-white rounded-lg shadow-lg p-6 mb-6">
        <h1 class="text-4xl font-bold text-black">Úlovky</h1>
        <p class="text-lg text-blue-50https://www.sporttroc.com/files/categories/header/23557c54c8c01e80e3ced4036fc499c9.jpg">Sledujte své rybářské úspěchy a sdílejte je s ostatními!</p>
    </div>

    <div class="container mx-auto px-6 py-8 bg-gray-50 min-h-screen">

        <div class="flex justify-end mb-6">
            <a href="{{ route('ulovky.create') }}">
                <x-button class="bg-primarni hover:bg-primarniDarker text-white font-semibold py-3 px-5 rounded-lg shadow-lg transition duration-200 ease-in-out">
                    🎣 Zaznamenat úlovek
                </x-button>
            </a>
        </div>

        <!-- Filtry a vyhledávání -->
        <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
            <form action="{{ route('ulovky.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Moje  -->
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="moje" {{ request('moje') ? 'checked' : '' }}
                    onchange="this.form.submit()" class="rounded border-gray-300 text-blue-500 focus:ring-blue-400">
                    <span> Zobrazit jen moje úlovky</span>
                </label>

                <!-- Vyhledávání -->
                <div>
                    <input type="text" name="search" placeholder="🔍 Hledat..." value="{{ request('search') }}"
                           class="w-full border-gray-300 rounded-lg p-2 focus:ring-blue-400">
                </div>

                <!-- Řazení -->
                <div>
                    <select name="sort" class="w-full border-gray-300 rounded-lg p-2 focus:ring-blue-400" onchange="this.form.submit()">
                        <option value="">-- Vyberte řazení --</option>
                        <option value="delka" {{ request('sort') == 'delka' ? 'selected' : '' }}>Délka</option>
                        <option value="vaha" {{ request('sort') == 'vaha' ? 'selected' : '' }}>Váha</option>
                    </select>
                </div>
            </form>
        </div>


        <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
            <table class="table-auto w-full text-left border-collapse border border-gray-200">
                <thead class="bg-primarni text-white uppercase text-sm">
                <tr>
                    <th class="p-4 border">Autor</th>
                    <th class="p-4 border">Délka</th>
                    <th class="p-4 border">Váha</th>
                    <th class="p-4 border">Druh ryby</th>
                    <th class="p-4 border">Lokalita</th>
                    <th class="p-4 border">Typ lovu</th>
                    <th class="p-4 border">Akce</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($vsechnyUlovky as $ulovek)
                    <tr class="hover:bg-blue-50 transition">
                        <td class="p-4 border">{{ $ulovek->uzivatel->name ?? 'N/A' }}</td>
                        <td class="p-4 border">{{ $ulovek->delka }} cm</td>
                        <td class="p-4 border">{{ $ulovek->vaha }} kg</td>
                        <td class="p-4 border">{{ $ulovek->druh_ryby }}</td>
                        <td class="p-4 border">{{ $ulovek->lokalita->nazev_lokality ?? 'N/A' }}</td>
                        <td class="p-4 border">{{ $ulovek->typLovu->druh ?? 'N/A' }}</td>
                        <td class="p-4 border flex space-x-2">
                            <a href="{{ route('ulovky.detail', $ulovek->id) }}"
                               class="bg-primarni text-white px-3 py-2 rounded-lg shadow hover:bg-primarniDarker">
                                Detail
                            </a>
                            @if(auth()->user()->isAdmin() || auth()->user()->id === $ulovek->id_uzivatele)
                                <form action="{{ route('ulovky.destroy', $ulovek->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-pozor text-white px-3 py-2 rounded-lg shadow hover:bg-red-600"
                                            onclick="return confirm('Opravdu chcete smazat tento úlovek?')">Smazat</button>
                                </form>
                            @endif
                            <p>{{ $ulovek->likeCount() }} likes</p>
                            <form action="{{ route('ulovky.like', $ulovek->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="text-red-500">
                                    @if($ulovek->likes()->where('user_id', auth()->id())->exists())
                                        ❤️
                                    @else
                                        🤍
                                    @endif
                                </button>
                            </form>

                            <form action="{{ route('ulovky.save', $ulovek->id) }}" method="POST">
                                @csrf
                                <button type="submit">
                                    @if ($ulovek->saves()->where('user_id', auth()->id())->exists())
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
        </div>


        <div class="mt-6">
            {{ $vsechnyUlovky->links() }}
        </div>
    </div>
</x-app-layout>

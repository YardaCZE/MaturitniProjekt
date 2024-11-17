<x-app-layout>
    <a href="{{ route('prispevky.create', ['skupina_id' => $skupina->id]) }}">
        <x-button>
            Vytvořit nový příspěvek
        </x-button>
    </a>

    @if(auth()->user()->isAdmin() || auth()->user()->id === $skupina->id_admin)
        <a href="{{ route('pozvanky.admin', ['id' => $skupina->id]) }}">
            <x-button>
                Admin panel
            </x-button>
        </a>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h1 class="text-2xl font-semibold text-gray-800 leading-tight">{{ $skupina->nazev_skupiny }} - Soukromé lokality</h1>

                <h1>Úlovky</h1>



                <!-- Vyhledávání -->
                <form action="{{ route('ulovky.index') }}" method="GET" class="mb-3">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Hledat..." value="{{ request('search') }}">
                        <x-button class="btn btn-primary" type="submit">Hledat</x-button>
                    </div>
                </form>

                <!-- Řazení -->
                <form action="{{ route('ulovky.index') }}" method="GET" class="mb-3">
                    <div class="input-group">
                        <select name="sort" class="form-select" onchange="this.form.submit()">
                            <option value="">-- Vyberte řazení --</option>
                            <option value="delka" {{ request('sort') == 'delka' ? 'selected' : '' }}>Délka</option>
                            <option value="vaha" {{ request('sort') == 'vaha' ? 'selected' : '' }}>Váha</option>
                        </select>
                        <x-button type="button" class="btn btn-secondary" onclick="resetFilters()">Vymazat filtry</x-button>
                    </div>
                </form>




                <h2> úlovky</h2>
                <table class="table table-bordered mt-3">
                    <thead>
                    <tr>
                        <th>Autor</th>
                        <th>Délka</th>
                        <th>Váha</th>
                        <th>Druh ryby</th>
                        <th>Lokalita</th>
                        <th>Typ lovu</th>
                        <th>Akce</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($soukromeUlovky as $ulovek)
                        <tr>
                            <td>{{ $ulovek->uzivatel->name ?? 'N/A' }}</td>
                            <td>{{ $ulovek->delka }} cm</td>
                            <td>{{ $ulovek->vaha }} kg</td>
                            <td>{{ $ulovek->druh_ryby }}</td>
                            <td>{{ $ulovek->lokalita->nazev_lokality ?? 'N/A' }}</td>
                            <td>{{ $ulovek->typLovu->druh ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('ulovky.detail', $ulovek->id) }}" class="btn btn-info">Detail</a>
                                @if(auth()->user()->isAdmin() || auth()->user()->id === $ulovek->id_uzivatele)
                                    <form action="{{ route('ulovky.destroy', $ulovek->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <x-button type="submit" class="btn btn-danger" onclick="return confirm('Opravdu chcete smazat tento úlovek?')">Smazat</x-button>
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

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $soukromeUlovky->links() }}
                </div>

                <a href="{{ route('skupiny.index') }}">
                    <x-button>
                        Zpět na seznam skupin
                    </x-button>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>

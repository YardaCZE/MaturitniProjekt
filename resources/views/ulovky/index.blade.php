<x-app-layout>
    <div class="container mx-auto px-6 py-8">
        <div class="flex justify-end mb-6">
            <a href="{{ route('ulovky.create') }}">
                <x-button class="bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-5 rounded-lg shadow-lg transition duration-200 ease-in-out">
                    Zaznamenat úlovek
                </x-button>
            </a>
        </div>

        <h1>Úlovky</h1>

        <!-- Filtr pro zobrazení jen mých úlovků -->
        <form action="{{ route('ulovky.index') }}" method="GET" class="mb-3">
            <label>
                <input type="checkbox" name="moje" {{ request('moje') ? 'checked' : '' }} onchange="this.form.submit()">
                Zobrazit jen moje úlovky
            </label>
        </form>

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
            @foreach ($vsechnyUlovky as $ulovek)
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
        <div class="mt-4">
            {{ $vsechnyUlovky->links() }}
        </div>

    </div>

    <script>
        function resetFilters() {
            const url = new URL(window.location.href);
            url.searchParams.delete('search');
            url.searchParams.delete('sort');
            window.location.href = url;
        }
    </script>
</x-app-layout>

<x-app-layout>
    <div class="container">
        <h1>Úlovky</h1>

        <!-- Search Bar -->
        <form action="{{ route('ulovky.index') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Hledat..." value="{{ request('search') }}">
                <button class="btn btn-primary" type="submit">Hledat</button>
            </div>
        </form>

        <!-- Sorting Options -->
        <form action="{{ route('ulovky.index') }}" method="GET" class="mb-3">
            <div class="input-group">
                <select name="sort" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Vyberte řazení --</option>
                    <option value="delka" {{ request('sort') == 'delka' ? 'selected' : '' }}>Délka</option>
                    <option value="vaha" {{ request('sort') == 'vaha' ? 'selected' : '' }}>Váha</option>
                </select>
                <button type="button" class="btn btn-secondary" onclick="resetFilters()">Vymazat filtry</button>
            </div>
        </form>

        <!-- Table for displaying catches -->
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
            @foreach ($ulovky as $ulovek)
                <tr>
                    <td>{{ $ulovek->uzivatel->name ?? 'N/A' }}</td>
                    <td>{{ $ulovek->delka }}</td>
                    <td>{{ $ulovek->vaha }}</td>
                    <td>{{ $ulovek->druh_ryby }}</td>
                    <td>
                        <a href="{{ route('ulovky.index', ['search' => $ulovek->lokalita->nazev_lokality]) }}">
                            {{ $ulovek->lokalita->nazev_lokality ?? 'N/A' }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('ulovky.index', ['search' => $ulovek->typLovu->druh]) }}">
                            {{ $ulovek->typLovu->druh ?? 'N/A' }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('ulovky.detail', $ulovek->id) }}" class="btn btn-info">Detail</a>
                        @if(auth()->user()->isAdmin() || auth()->user()->id === $ulovek->uzivatel)
                        <form action="{{ route('ulovky.destroy', $ulovek->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Opravdu chcete smazat tento úlovek?')">Smazat</button>
                        </form>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        {{ $ulovky->links() }}
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

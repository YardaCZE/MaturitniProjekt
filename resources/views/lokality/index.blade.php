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

        <!-- Table for displaying catches -->
        <table class="table table-bordered mt-3">
            <thead>
            <tr>
                <th>ID</th>
                <th>Délka</th>
                <th>Váha</th>
                <th>Druh ryby</th>
                <th>Typ lovu</th>
                <th>Akce</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($ulovky as $ulovek)
                <tr>
                    <td>{{ $ulovek->id }}</td>
                    <td>{{ $ulovek->delka }}</td>
                    <td>{{ $ulovek->vaha }}</td>
                    <td>{{ $ulovek->druh_ryby }}</td>
                    <td>{{ $ulovek->typLovu->druh ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('ulovky.show', $ulovek->id) }}" class="btn btn-info">Detail</a>
                        <form action="{{ route('ulovky.destroy', $ulovek->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Opravdu chcete smazat tento úlovek?')">Smazat</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        {{ $ulovky->links() }}
    </div>
</x-app-layout>

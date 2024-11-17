<x-app-layout>
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold mb-6">Uložené lokality</h1>

        @if ($ulozeneLokality->isEmpty())
            <p>Nemáte žádné uložené lokality.</p>
        @else
            <table class="table-auto w-full border-collapse border border-gray-300">
                <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="py-3 px-6 border-b border-gray-300">Název</th>
                    <th class="py-3 px-6 border-b border-gray-300">Druh</th>
                    <th class="py-3 px-6 border-b border-gray-300">Rozloha</th>
                    <th class="py-3 px-6 border-b border-gray-300">Kraj</th>
                    <th class="py-3 px-6 border-b border-gray-300">Souřadnice</th>
                    <th class="py-3 px-6 border-b border-gray-300 text-center">Akce</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($ulozeneLokality as $lokalita)
                    <tr class="hover:bg-gray-100 transition duration-200">
                        <td class="py-3 px-6 border-b border-gray-300">{{ $lokalita->nazev_lokality }}</td>
                        <td class="py-3 px-6 border-b border-gray-300">{{ $lokalita->druh }}</td>
                        <td class="py-3 px-6 border-b border-gray-300">{{ $lokalita->rozloha }} ha</td>
                        <td class="py-3 px-6 border-b border-gray-300">{{ $lokalita->kraj }}</td>
                        <td class="py-3 px-6 border-b border-gray-300">{{ $lokalita->souradnice }}</td>
                        <td class="py-3 px-6 border-b border-gray-300 text-center">
                            <a href="{{ route('lokality.detail', $lokalita->id) }}">
                                <x-button class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-1 px-3 rounded-md shadow transition duration-200 ease-in-out mr-2">
                                    Detail
                                </x-button>
                            </a>
                            @if(auth()->user()->isAdmin() || auth()->user()->id === $lokalita->id_zakladatele)
                                <form action="{{ route('lokality.destroy', $lokalita->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <x-button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-1 px-3 rounded-md shadow transition duration-200 ease-in-out" onclick="return confirm('Opravdu chcete smazat tuto lokalitu?');">
                                        Smazat
                                    </x-button>
                                </form>
                            @endif

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
        @endif


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
            @foreach ($ulozeneUlovky as $ulovek)
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
                        </form>

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
</x-app-layout>

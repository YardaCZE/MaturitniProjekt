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
    </div>
</x-app-layout>

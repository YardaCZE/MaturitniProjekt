<x-app-layout>
    <div class="container mx-auto px-6 py-8">

        <div class="flex justify-end mb-6">
            <a href="{{ route('lokality.create') }}">
                <x-button class="bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-5 rounded-lg shadow-lg transition duration-200 ease-in-out">
                    Vytvořit lokalitu
                </x-button>
            </a>
        </div>


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
                @foreach ($lokality as $lokalita)
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
                            @if(auth()->user()->isAdmin())
                            <form action="{{ route('lokality.destroy', $lokalita->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <x-button type="submit" class="bg-red-600 hover:bg-red-600 text-white font-semibold py-1 px-3 rounded-md shadow transition duration-200 ease-in-out" onclick="return confirm('Opravu chcete smazat tuto lokalitu?');">
                                    Smazat
                                </x-button>
                            </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>

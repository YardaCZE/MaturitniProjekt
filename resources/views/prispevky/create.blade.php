<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg p-8 border border-gray-200">

                <h1 class="text-4xl font-bold text-gray-900 leading-tight mb-8 border-b pb-4">Vytvořit nový příspěvek</h1>


                <form action="{{ route('prispevky.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="skupina_id" value="{{ $skupina_id }}">


                    <div class="mb-6">
                        <x-label for="nadpis" value="Nadpis" class="text-xl font-medium text-gray-700" />
                        <x-input id="nadpis" class="block mt-2 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" type="text" name="nadpis" placeholder="Zadejte nadpis" required />
                    </div>


                    <div class="mb-6">
                        <x-label for="text" value="Text" class="text-xl font-medium text-gray-700" />
                        <textarea id="text" name="text" class="block mt-2 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" rows="5" placeholder="Napište obsah příspěvku" required></textarea>
                    </div>


                    <div class="mb-6">
                        <x-label for="obrazky" value="Obrázky" class="text-xl font-medium text-gray-700" />
                        <input id="obrazky" type="file" name="obrazky[]" class="mt-2 block w-full text-gray-700 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" multiple>
                        <small class="text-gray-500">Můžete nahrát více obrázků </small>
                    </div>


                    <div class="mb-6">
                        @if ($errors->any())
                            <div class="bg-red-50 border-l-4 border-red-400 text-red-700 p-4 rounded-md">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>


                    <div class="flex justify-between items-center">
                        <x-button class="bg-indigo-600 text-white font-semibold px-6 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            Vytvořit příspěvek
                        </x-button>

                        <a href="{{ route('skupiny.index') }}" class="text-indigo-600 font-medium hover:underline">Zpět na seznam skupin</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg p-8">
                <h1 class="text-3xl font-semibold text-gray-800 leading-tight mb-6">Vytvořit nový příspěvek</h1>

                <form action="{{ route('prispevky.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="skupina_id" value="{{ $skupina_id }}">

                    <div class="mb-6">
                        <x-label for="nadpis" value="Nadpis" class="text-lg font-medium" />
                        <x-input id="nadpis" class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm" type="text" name="nadpis" required />
                    </div>

                    <div class="mb-6">
                        <x-label for="text" value="Text" class="text-lg font-medium" />
                        <textarea id="text" name="text" class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm" rows="5" required></textarea>
                    </div>

                    <div class="mb-6">
                        <x-label for="obrazky" value="Obrázky" class="text-lg font-medium" />
                        <input id="obrazky" type="file" name="obrazky[]" class="mt-2 text-gray-700" multiple>
                        <small class="text-gray-500">Můžete nahrát více obrázků.</small>
                    </div>

                    <div class="mb-6">
                        @if ($errors->any())
                            <div class="bg-red-50 border border-red-400 text-red-600 p-4 rounded-lg">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    <div class="flex space-x-4">
                        <x-button class="bg-indigo-600 text-white font-semibold px-6 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            Vytvořit příspěvek
                        </x-button>
                    </div>
                </form>
                <div class="flex space-x-4">
                <a href="{{ route('skupiny.index') }}" class="inline-block">
                    <x-button class="bg-gray-500 text-white font-semibold px-6 py-2 rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400">
                        Zpět na seznam skupin
                    </x-button>
                </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

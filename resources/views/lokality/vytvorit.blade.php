<x-app-layout>
    <div class="container mx-auto px-4 max-w-lg">
        <h1 class="text-2xl font-semibold mb-6 text-gray-700 text-center">Vytvořit lokalitu</h1>

        <form action="{{ route('lokality.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
            @csrf
            <div class="mb-4">
                <label for="nazev_lokality" class="block text-gray-700 font-medium mb-2">Název lokality</label>
                <input type="text" name="nazev_lokality" required class="form-input w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="druh" class="block text-gray-700 font-medium mb-2">Druh</label>
                <input type="text" name="druh" required class="form-input w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="rozloha" class="block text-gray-700 font-medium mb-2">Rozloha</label>
                <input type="number" step="0.01" name="rozloha" required class="form-input w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="kraj" class="block text-gray-700 font-medium mb-2">Kraj</label>
                <input type="text" name="kraj" required class="form-input w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="souradnice" class="block text-gray-700 font-medium mb-2">Souradnice</label>
                <input type="text" name="souradnice" required class="form-input w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="obrazky" class="block text-gray-700 font-medium mb-2">Obrázky</label>
                <input type="file" name="obrazky[]" multiple class="w-full text-gray-700 py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <small class="text-gray-500">Můžete nahrát více obrázků.</small>
            </div>

            <x-button type="submit" class=" bg-indigo-600 text-white font-semibold py-3 rounded-md shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                Vytvořit
            </x-button>
        </form>
    </div>
</x-app-layout>

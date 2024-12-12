<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h1 class="text-2xl font-semibold text-gray-800 leading-tight mb-6">Přihlásit se do soukromé skupiny</h1>

                @if ($errors->any())
                    <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                <h2 class="mt-6 text-xl font-semibold text-gray-800">Přihlásit se pomocí pozvánky:</h2>
                <form action="{{ route('skupiny.prihlasit_pozvankou') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="kod_pozvanky" class="block text-gray-700 font-medium mb-2">Kód pozvánky:</label>
                        <input type="text" name="kod_pozvanky" required class="border border-gray-300 rounded-md shadow-sm px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Zadejte kód pozvánky">
                    </div>

                    <x-button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                        Přihlásit se
                    </x-button>
                </form>


                <h2 class="mt-6 text-xl font-semibold text-gray-800">Přihlásit se pomocí názvu a hesla</h2>

                <form action="{{ route('skupiny.prihlasit') }}" method="POST" class="mb-8">
                    @csrf
                    <div class="mb-4">
                        <label for="nazev_skupiny" class="block text-gray-700 font-medium mb-2">Název skupiny:</label>
                        <input type="text" name="nazev_skupiny" required class="border border-gray-300 rounded-md shadow-sm px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Zadejte název skupiny">
                    </div>

                    <div class="mb-4">
                        <label for="heslo" class="block text-gray-700 font-medium mb-2">Heslo:</label>
                        <input type="password" name="heslo" required class="border border-gray-300 rounded-md shadow-sm px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Zadejte heslo">
                    </div>

                    <x-button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                        Přihlásit se
                    </x-button>
                </form>




            </div>
        </div>
    </div>
</x-app-layout>

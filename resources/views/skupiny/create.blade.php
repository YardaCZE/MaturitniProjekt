<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg p-8">
                <h1 class="text-3xl font-semibold text-gray-800 leading-tight mb-6">Vytvořit novou skupinu</h1>

                <form action="{{ route('skupiny.store') }}" method="POST">
                    @csrf

                    <div class="mb-6">
                        <x-label for="nazev_skupiny" value="Název skupiny" class="text-lg font-medium" />
                        <x-input id="nazev_skupiny" class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm" type="text" name="nazev_skupiny" required />
                    </div>

                    <div class="mb-6">
                        <input type="hidden" name="je_soukroma" value="0">
                        <label for="je_soukroma" class="text-lg font-medium flex items-center space-x-2">
                            <input type="checkbox" name="je_soukroma" id="je_soukroma" value="1" class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
                            <span>Je skupina soukromá?</span>
                        </label>
                    </div>

                    <div id="heslo_container" class="mb-6" style="display: none;">
                        <x-label for="heslo" value="Heslo" class="text-lg font-medium" />
                        <x-input id="heslo" class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm" type="password" name="heslo" />
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
                        <x-button class="bg-primarni text-white font-semibold px-6 py-2 rounded-md hover:bg-primarniDarker focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            Vytvořit skupinu
                        </x-button>
                    </div>
                </form>

                <div class="mt-4">
                    <a href="{{ route('skupiny.index') }}" class="inline-block">
                        <x-button class="bg-primarni text-white font-semibold px-6 py-2 rounded-md hover:bg-primarniDarker focus:outline-none focus:ring-2 focus:ring-gray-400">
                            Zpět na seznam skupin
                        </x-button>
                    </a>
                </div>

                <script>
                    document.getElementById('je_soukroma').addEventListener('change', function() {
                        var hesloContainer = document.getElementById('heslo_container');
                        hesloContainer.style.display = this.checked ? 'block' : 'none';
                    });
                </script>
            </div>
        </div>
    </div>
</x-app-layout>

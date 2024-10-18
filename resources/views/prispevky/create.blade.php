<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h1 class="text-2xl font-semibold text-gray-800 leading-tight">Vytvořit nový příspěvek</h1>

                <form action="{{ route('prispevky.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mt-4">
                        <x-label for="nadpis" value="Nadpis" />
                        <x-input id="nadpis" class="block mt-1 w-full" type="text" name="nadpis" required />
                    </div>

                    <div class="mt-4">
                        <x-label for="text" value="Text" />
                        <textarea id="text" name="text" class="block mt-1 w-full" rows="5" required></textarea>
                    </div>

                    <div class="mt-4">
                        <x-label for="obrazky" value="Obrázky" />
                        <input id="obrazky" type="file" name="obrazky[]" multiple>
                    </div>

                    <div class="mt-4">
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                    </div>

                    <div class="mt-4">
                        <x-button>
                            Vytvořit příspěvek
                        </x-button>
                    </div>
                </form>

                <a href="{{ route('skupiny.index') }}">
                    <x-button>
                        Zpět na seznam skupin
                    </x-button>
                </a>

            </div>
        </div>
    </div>
</x-app-layout>

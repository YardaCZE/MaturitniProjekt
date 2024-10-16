<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <h1 class="text-2xl font-semibold text-gray-800 leading-tight">Vytvořit novou skupinu</h1>

                    <form action="{{ route('skupiny.store') }}" method="POST">
                        @csrf
                        <label for="nazev_skupiny">Název skupiny:</label>
                        <input type="text" name="nazev_skupiny" required>

                        <input type="hidden" name="je_soukroma" value="0"> <!-- Přidáno pro zajištění výchozí hodnoty -->
                        <label for="je_soukroma">Je skupina soukromá?</label>
                        <input type="checkbox" name="je_soukroma" id="je_soukroma" value="1">

                        <div id="heslo_container" style="display: none;">
                            <label for="heslo">Heslo:</label>
                            <input type="password" name="heslo">
                        </div>
                        <x-button>Vytvořit skupinu</x-button>

                    </form>

                    <script>
                        document.getElementById('je_soukroma').addEventListener('change', function() {
                            var hesloContainer = document.getElementById('heslo_container');
                            hesloContainer.style.display = this.checked ? 'block' : 'none';
                        });
                    </script>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li class="text-red-600>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                        <x-button>
                    <a href="{{ route('skupiny.index') }}">Zpět na seznam skupin</a>
                            </x-button>
            </div>
        </div>
    </div>

    </x-app-layout>


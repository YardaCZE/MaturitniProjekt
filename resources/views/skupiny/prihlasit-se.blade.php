<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h1 class="text-2xl font-semibold text-gray-800 leading-tight">Přihlásit se do soukromé skupiny</h1>


                <form action="{{ route('skupiny.prihlasit') }}" method="POST">
                    @csrf
                    <label for="nazev_skupiny">Název skupiny:</label>
                    <input type="text" name="nazev_skupiny" required>

                    <label for="heslo">Heslo:</label>
                    <input type="password" name="heslo" required>

                    <x-button>Přihlásit se</x-button>
                </form>


                <h2 class="mt-6 text-xl">Přihlásit se pomocí pozvánky:</h2>
                <form action="{{ route('skupiny.prihlasit_pozvankou') }}" method="POST">
                    @csrf
                    <label for="kod_pozvanky">Kód pozvánky:</label>
                    <input type="text" name="kod_pozvanky" required>

                    <x-button>Přihlásit se</x-button>
                </form>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li class="text-red-600">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
<h1>Vytvořit novou skupinu</h1>

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
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <x-button>
<a href="{{ route('skupiny.index') }}">Zpět na seznam skupin</a>
        </x-button>
    </x-app-layout>


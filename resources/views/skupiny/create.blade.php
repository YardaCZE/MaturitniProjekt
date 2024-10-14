<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vytvořit Skupinu</title>
</head>
<body>
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

    <button type="submit">Vytvořit skupinu</button>
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

<a href="{{ route('skupiny.index') }}">Zpět na seznam skupin</a>
</body>
</html>


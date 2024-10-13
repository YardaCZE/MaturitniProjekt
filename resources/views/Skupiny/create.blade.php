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

    <label for="je_soukroma">Je skupina soukromá?</label>
    <input type="hidden" name="je_soukroma" value="0"> <!-- Skryté pole -->
    <input type="checkbox" name="je_soukroma" value="1" {{ old('je_soukroma') ? 'checked' : '' }}>

    <label for="heslo">Heslo (pokud je soukromá):</label>
    <input type="password" name="heslo" {{ old('je_soukroma') ? 'required' : '' }}>

    <button type="submit">Vytvořit</button>
</form>

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

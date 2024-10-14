<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Přihlásit se do soukromé skupiny</title>
</head>
<body>
<h1>Přihlásit se do soukromé skupiny</h1>

<form action="{{ route('skupiny.prihlasit') }}" method="POST">
    @csrf
    <label for="nazev_skupiny">Název skupiny:</label>
    <input type="text" name="nazev_skupiny" required>

    <label for="heslo">Heslo:</label>
    <input type="password" name="heslo" required>

    <button type="submit">Přihlásit se</button>
</form>

</body>
</html>

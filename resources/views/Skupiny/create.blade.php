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
    @csrf <!-- Ochrana proti CSRF útokům -->

    <label for="nazev_skupiny">Název skupiny:</label>
    <input type="text" name="nazev_skupiny" id="nazev_skupiny" required>

    <label for="je_soukroma">Soukromá skupina:</label>
    <input type="checkbox" name="je_soukroma" id="je_soukroma" value="1">

    <button type="submit">Vytvořit</button>
</form>
</body>
</html>

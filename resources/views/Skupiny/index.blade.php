<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skupiny</title>
</head>
<body>
<h1>Seznam Skupin</h1>
<a href="{{ route('skupiny.create') }}">Vytvořit skupinu</a>


<ul>
    @foreach($skupiny as $skupina)
        <li>
            {{ $skupina->nazev_skupiny }}
            <a href="{{ route('skupiny.show', $skupina->id) }}">Otevřít skupinu</a>
        </li>
    @endforeach
</ul>
</body>
</html>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $skupina->nazev_skupiny }}</title>
</head>
<body>
<h1>{{ $skupina->nazev_skupiny }}</h1>

<h2>Příspěvky ve skupině</h2>
<ul>
    @foreach($prispevky as $prispevek)
        <li>
            <strong>{{ $prispevek->nadpis }}</strong><br>
            {{ $prispevek->text }}<br>
        </li>
    @endforeach
</ul>

<a href="{{ route('skupiny.index') }}">Zpět na seznam skupin</a>
</body>
</html>

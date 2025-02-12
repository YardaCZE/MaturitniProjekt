<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stránka nenalezena - 404</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
<div class="text-center">
    <h1 class="text-6xl font-bold text-red-500">404</h1>
    <p class="text-xl text-gray-600 mt-4">Stránka, kterou hledáte, nebyla nalezena.</p>
    <p class="text-lg text-gray-500 mt-2">Zkontrolujte URL nebo se vraťte zpět na dashboard.</p>
    <a href="{{ route('dashboard') }}" class="mt-6 inline-block px-6 py-3 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 transition duration-300">Na dashboard</a>
</div>
</body>
</html>

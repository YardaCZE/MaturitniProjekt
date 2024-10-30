<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="font-sans antialiased bg-gray-100">
<header class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 py-4">
        @if (Route::has('login'))
            <nav class="flex justify-center">
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-gray-600 hover:text-blue-600 px-4">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 px-4">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="text-gray-600 hover:text-blue-600 px-4">Register</a>
                    @endif
                @endauth
            </nav>
        @endif
    </div>
</header>

<main class="flex items-center justify-center min-h-screen">
    <div class="bg-white rounded-lg shadow-lg p-8 max-w-md w-full">
        <div class="text-center">
            @auth
                <h1 class="text-2xl font-bold text-center text-red-500 mb-4">Ahoj, jdi na dashboard!</h1>

                <p class="text-gray-600">Jsi přihlášen jako {{ Auth::user()->name }}.</p>
            @else
                <h1 class="text-2xl font-bold text-center text-red-500 mb-4">Ahoj, přihlaš se a potom jdi na dashboard</h1>

                <p class="text-center text-gray-700 mb-6">Vítej! Přihlaš se, abys mohl využívat všechny funkce aplikace.</p>

                <a href="{{ route('login') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Přihlásit se</a>
                <p class="mt-4">Nemáš účet? <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Zaregistruj se</a></p>
            @endauth
        </div>
    </div>
</main>
</body>
</html>

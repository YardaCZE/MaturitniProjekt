<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>




</head>
        <body class="font-sans antialiased">
                @if (Route::has('login'))
                    <nav class="-mx-3 flex flex-1 justify-end">
                        @auth
                            <a
                                href="{{ url('/dashboard') }}"
                            >
                                Dashboard
                            </a>
                        @else
                            <a
                                href="{{ route('login') }}"
                                class="mr-6"
                            >
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a
                                    href="{{ route('register') }}"
                                    class="mr-6"
                                >
                                    Register
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif

            <div>
                <h1 class="text-red-500">Ahoj, přihlaš se a potom jdi na dashboard</h1>

            </div>
        </body>
</html>

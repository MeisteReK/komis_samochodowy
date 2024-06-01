<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        html, body {
            height: 100%;
        }
        body {
            display: flex;
            flex-direction: column;
        }
        #app {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        main {
            flex: 1;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand me-auto" href="{{ url('/') }}">
                    Komis samochodowy
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('offers.index') }}">Oferty</a>
                        </li>
                        @auth
                            @if(Auth::user()->role == 'client')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('reservations.index') }}">Moje Rezerwacje</a>
                                </li>
                            @endif
                            @if(Auth::user()->role == 'admin')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('offers.create') }}">Dodaj Ofertę</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('users.index') }}">Użytkownicy</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('reservations.index_admin') }}">Wszystkie Rezerwacje</a>
                                </li>
                            @endif
                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>


        <footer class="bg-light text-dark py-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <h5>Komis samochodowy</h5>
                        <address>
                            <p>ul. Czerwonych latarni</p>
                            <p>Telefon: <a href="tel:+48123456789">+48 696 969 696</a></p>
                            <p>Email: <a href="mailto:info@komis.pl">prosimy_o_5_@komis.pl</a></p>
                        </address>
                    </div>
                    <div class="col-md-4 mb-3">
                        <h5>Nawigacja</h5>
                        <ul class="list-unstyled">
                            <li><a href="{{ url('/') }}">Strona główna</a></li>
                            <li><a href="{{ route('offers.index') }}">Oferty</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4 mb-3">
                        <h5>Śledź nas</h5>
                        <ul class="list-unstyled">
                            <li><a href="#">Facebook</a></li>
                            <li><a href="#">Twitter</a></li>
                            <li><a href="#">Instagram</a></li>
                        </ul>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <p>&copy; 2024 Komis samochodowy. Wszelkie prawa zastrzeżone.</p>
                </div>
            </div>
        </footer>


    </div>
</body>
</html>

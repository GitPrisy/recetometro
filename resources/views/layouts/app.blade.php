<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
        crossorigin="anonymous" />

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sidenav.css') }}" rel="stylesheet">
    <link href="{{ asset('css/cards.css') }}" rel="stylesheet">
    <link href="{{ asset('css/carousel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    
    <script data-ad-client="ca-pub-3650069535362055" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
</head>

<body>
    <div id="app">
        <!-- Sidebar menu -->
        <div id="mySidenav" class="sidenav">

            <span id="sidebar-button-close" class="icon-light" onclick="closeNav()"><i class="fas fa-times"></i></span>

            <div>
                <h2><a href="/">Inicio</a></h2>
                <h2><a href="#"></a></h2>
                @auth
                <h2><a href="{{ route('perfil.index', Auth::user()->nickname) }}">Perfil</a></h2>
                @endauth
                <h2><a href="#">Contact</a></h2>
                @guest
                    <h2><a href="{{ route('login') }}">Iniciar sesión</a></h2>
                    <h2><a href="{{ route('register') }}">Crear cuenta</a></h2>
                @endguest
                @auth
                    <h2><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Cerrar sesión
                    </a></h2>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @endauth
            </div>
        </div>
        <!-- Main navbar -->
        <nav class="navbar navbar-light bg-light sticky-top" style="z-index: 4;">
            <div class="col-3 d-flex justify-content-start">
                <span id="sidebar-button-open" class="icon-dark" onclick="openNav()"><i class="fas fa-bars"></i></span>
                <!-- <h4 class="mt-1"><strong>MENU</strong></h4> -->
            </div>
            <div class="col-6 d-flex justify-content-center">
                <h1 class="logo text-dark ml-md-0">Recetometro</h1>
            </div>

            <div class="col-3 d-flex justify-content-end">
                <!-- <h4 class="mt-2 mx-3"><strong>CREA</strong></h4> -->
                <span class="icon-dark"><a class="text-dark" href="{{ route('receta.create') }}"><i class="fas fa-bars"></i></a></span>
            </div>
            <!-- <div class="col-3 d-flex justify-content-end">
                <form class="form-inline d-none d-md-flex">
                    <input class="form-control mb-2" type="search" placeholder="Search" aria-label="Search">
                </form>
            </div> -->
        </nav>
        <main class="py-4">
            @yield('content')

            @yield('footer')
        </main>

    </div>
    <script>
        function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
        }
    </script>
</body>

</html>

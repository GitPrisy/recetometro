<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preload" href="{{ asset('js/app.js') }}" as="script">
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
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" rel="preload">
    <link href="{{ asset('css/sidenav.css') }}" rel="stylesheet" rel="preload">
    <link href="{{ asset('css/cards.css') }}" rel="stylesheet" rel="preload">
    <link href="{{ asset('css/carousel.css') }}" rel="stylesheet" rel="preload">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet" rel="preload">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    
    <script data-ad-client="ca-pub-3650069535362055" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
</head>

<body>
    <div id="app">
        <!-- Sidebar menu -->
        <div id="mySidenav" class="sidenav">

            <span id="sidebar-button-close" class="icon-light"><i class="fas fa-times"></i></span>

            <div class="menu">
                <h2><a href="https://recetometro.es/">Inicio</a></h2>
                @auth
                <h2><a href="{{ route('receta.create') }}">Nueva receta</a></h2>
                <h2><a href="{{ route('perfil.index', Auth::user()->nickname) }}">Perfil</a></h2>
                @endauth
                @guest
                    <h2><a href="{{ route('register') }}">Nueva receta</a></h2>
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
            <!-- Footer -->
            <footer class="text-center">
                <div class="d-flex align-content-end justify-content-center flex-wrap social px-4 py-2">
                    <section class="mt-3">
                        <div class="row justify-content-center">
                            <div class="col">
                                <a class="icon-light " href="https://www.facebook.com/Recetometro-107552824877778">
                                    <i class="fab fa-facebook-f"></i>
                                </a>

                                <a class="icon-light " href="https://twitter.com/xprisy">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            </div>
                            <div class="col">
                                <a class="icon-light " href="https://www.instagram.com/recetometro/">
                                    <i class="fab fa-instagram"></i>
                                </a>

                                <a class="icon-light " href="https://github.com/GitPrisy/recetometro">
                                    <i class="fab fa-github"></i>
                                </a>
                            </div>
                        </div>
                    </section>
                    <section class="mt-3">
                        <div class="row justify-content-center">
                            <div class="col">
                                <h5>Enlaces de interés: </h5>
                                <a href="#!" class="mx-5">Sobre nosotros</a>
                                <a href="#!" class="mx-5">Contáctanos</a>
                                <a href="#!" class="mx-5">Privacidad</a>
                            </div>
                        </div>
                    </section>
                    <span class="copy">© 2021 Copyright:</span>
                    <a class="text-white">Recetometro</a>
                </div>
            </footer>
        </div>
        <!-- Main navbar -->
        <nav class="navbar navbar-light bg-light sticky-top" style="z-index: 4;">
            <div class="col-3 d-flex justify-content-start">
                <span id="sidebar-button-open" class="icon-dark"><i class="fas fa-bars"></i></span>
            </div>
            <div class="col-6 d-flex justify-content-center">
                <h1 class="logo text-dark ml-md-0">Recetometro</h1>
            </div>

            <div class="col-3 d-flex justify-content-end">
                <span class="icon-dark"><a class="text-dark" href="{{ route('receta.create') }}"><i class="fas fa-bars"></i></a></span>
            </div>
        </nav>
        <main class="py-4">
            @yield('content')
        </main>

    </div>
    <script>
        $('#sidebar-button-open').on('click', function () {
            $('#mySidenav').width('250px');
            $("#mySidenav").click(function(e){
                e.stopPropagation(); 
            });
        });

        $(document).click(function(){
            if ( $('#mySidenav').width() >= 200) {
                $("#mySidenav").width('0px'); 
            }
        });

        $('#sidebar-button-close').on('click', function () {
            $('#mySidenav').width('0px');
        });
    </script>
</body>

</html>

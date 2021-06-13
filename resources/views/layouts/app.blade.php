<!doctype html>
<html lang="es_ES">

<head>
    <meta charset="utf-8">
    <!-- Primary Meta Tags -->
    <title>Recetometro — Tu próximo plato estrella</title>
    <meta name="title" content="Recetometro — Tu próximo plato estrella">
    <meta name="description" content="En Recetometro puedes encontrar recetas creadas por nuestra comunidad, aunque tú también te puedes unir y compartir tus mejores platos...">

    <link rel="shortcut icon" href="{{asset('favicon.ico')}}" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preload" href="{{ asset('js/app.js') }}" as="script">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Recetometro</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />

    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />

    <script src="{{ asset('js/app.js') }}"></script>

    <script data-ad-client="ca-pub-3650069535362055" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
</head>

<body>
    <div id="app">
        <div id="sidebar-menu" class="sidenav">
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
                <h2>
                    <a id="logout-a" href="{{ route('logout') }}">Cerrar sesión</a>
                </h2>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                @endauth
            </div>
            
            <footer class="text-center">
                <div class="d-flex align-content-end justify-content-center flex-wrap social px-4 py-2">
                    <section class="mt-3">
                        <div class="row">
                            <div class="col">
                                <a class="icon-light " href="https://www.facebook.com/Recetometro-107552824877778"><i class="fab fa-facebook-f"></i></a>

                                <a class="icon-light " href="https://twitter.com/xprisy"><i class="fab fa-twitter"></i></a>
                            </div>
                            <div class="col">
                                <a class="icon-light " href="https://www.instagram.com/recetometro/"><i class="fab fa-instagram"></i></a>

                                <a class="icon-light " href="https://github.com/GitPrisy/recetometro"><i class="fab fa-github"></i></a>
                            </div>
                        </div>
                    </section>
                    
                    <section class="mt-3">
                        <div class="row">
                            <div class="col">
                                <h5>Enlaces de interés: </h5>
                                <a href="https://recetometro.es/" class="mx-5">Sobre nosotros</a>
                                <a href="https://recetometro.es/coockies" class="mx-5">Coockies</a>
                                <a href="https://recetometro.es/privacidad" class="mx-5">Privacidad</a>
                            </div>
                        </div>
                    </section>
                    <span class="copy">© 2021 Copyright:</span>
                    <span class="text-white">Recetometro</span>
                </div>
            </footer>
        </div>

        <nav id="main-nav" class="navbar navbar-light bg-light sticky-top">
            <div class="col-3 d-flex">
                <span id="sidebar-button-open" class="icon-dark"><i class="fas fa-bars"></i></span>
            </div>
            <div class="col-6 d-flex justify-content-center">
                <h1 class="logo text-dark ml-md-0">
                    <a href="https://recetometro.es/">Recetometro</a>
                </h1>
            </div>

            <div class="col-3 d-flex justify-content-end">
                <form action="{{ route('receta.search') }}" method="GET" role="search" class="d-none d-md-flex">
                    <input class="form-control me-2" type="search" name="titulo" placeholder="Buscar">
                </form>
            </div>
            <form action="{{ route('receta.search') }}" method="GET" role="search" class="d-flex d-md-none">
                <input class="form-control me-2" type="search" name="titulo" placeholder="Buscar" aria-label="Search">
            </form>
        </nav>
        <span class="go-top icon-primary"><i class="fas fa-chevron-circle-up"></i></span>

        <main>
            @yield('content')
        </main>

    </div>
    <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>
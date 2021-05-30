@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-between">
            <h1 class="titulo-receta d-inline-block">
                {{$recipe->title}}
            </h1>
            @auth
            @if (Auth::user()->id == $recipe->user_id)
                <span class="icon-dark mt-2"><i class="fas fa-pen-alt"></i></span>
            @endif
            @endauth

        </div>
        <div id="carouser-receta" class="carousel mx-auto" data-ride="carousel" >


            <!-- The slideshow -->
            <div class="carousel-inner">
                @foreach ($recipe_images as $key=>$recipe_image)
                @if ($key == 0)
                <div class="carousel-item active">
                    <img src="/{{$recipe_image}}">
                </div>
                @else
                <div class="carousel-item">
                    <img src="/{{$recipe_image}}">
                </div>
                @endif
                @endforeach
            </div>

            <!-- Left and right controls -->
            <a class="carousel-control-prev" href="#carouser-receta" data-slide="prev">
                <i class="fas fa-angle-left"></i>
            </a>
            <a class="carousel-control-next" href="#carouser-receta" data-slide="next">
                <i class="fas fa-angle-right"></i>
            </a>
        </div>

        <h3 class="mt-4">Descripción: </h3>
        <div class="texto-receta">
            <p>{{$recipe->description}}</p>
        </div>

        <h3 class="mt-4">Ingredientes: </h3>
        <div class="texto-receta">
            <p>{{$recipe->ingredients}}</p>
        </div>

        <h3 class="mt-4">Preparación: </h3>
        <div class="texto-receta">
            <p>{{$recipe->preparation}}</p>
        </div>
    </div>

@endsection

@section('footer')
    <!-- Footer -->
    <footer class="bg-dark text-center text-white mt-5">
        <div class="container px-4 py-2">
            <section class="my-auto">

                <a class="icon-light m-1" href="#!" role="button">
                    <i class="fab fa-facebook-f"></i>
                </a>

                <a class="icon-light m-1" href="#!" role="button">
                    <i class="fab fa-twitter"></i>
                </a>

                <a class="icon-light m-1" href="#!" role="button">
                    <i class="fab fa-google"></i>
                </a>

                <a class="icon-light m-1" href="#!" role="button">
                    <i class="fab fa-instagram"></i>
                </a>

                <a class="icon-light m-1" href="#!" role="button">
                    <i class="fab fa-linkedin-in"></i>
                </a>

                <a class="icon-light m-1" href="#!" role="button">
                    <i class="fab fa-github"></i>
                </a>
            </section>
            <section class="mt-3">
                <div class="row justify-content-center">
                    <div class="col">
                        <h5>Enlaces de interés: </h5>
                        <a href="#!" class="text-white mx-5">Sobre nosotros</a>
                        <a href="#!" class="text-white mx-5">Contáctanos</a>
                        <a href="#!" class="text-white mx-5">Privacidad</a>
                    </div>
                </div>
            </section>
        </div>
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            © 2020 Copyright:
            <a class="text-white">Recetometro</a>
        </div>
    </footer>

@endsection

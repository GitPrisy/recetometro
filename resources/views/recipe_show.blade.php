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
                    <img class="img-fluid" src="/{{$recipe_image}}">
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
        <div class="texto-receta" id="ingredients" value="{{$recipe->ingredients}}">
        </div>

        <h3 class="mt-4">Preparación: </h3>
        <div class="texto-receta" id="preparation" value="{{$recipe->preparation}}">
        </div>
    </div>
    <script src="https://rawgit.com/jackmoore/autosize/master/dist/autosize.min.js"></script>
    <script>
        document.getElementById('ingredients').innerHTML = document.getElementById('ingredients').getAttribute('value')
        document.getElementById('preparation').innerHTML = document.getElementById('preparation').getAttribute('value')
    </script>
@endsection

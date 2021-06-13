@extends('layouts.app')
@section('content')
<div class="container">
    <div class="d-flex align-items-end">
        <h1 class="titulo-receta d-inline-block text-break">{{$recipe->title}}</h1>
    </div>

    @auth
    @if (Auth::user()->id == $recipe->user_id)
    <div class="d-flex align-items-end" style="margin-top: -1rem">
        <a class="text-primary" href="{{route('perfil.show', $recipe->user->nickname)}}"> by {{$recipe->user->nickname}}</a>
        <a class="ml-auto text-end" href="{{route('receta.edit', $recipe->slug)}}"><span class="icon-dark mt-2"><i class="far fa-edit"></i></span></a>
        <a type="button" data-dismiss="modal" class="ml-3" data-toggle="modal" data-target="#deleteRecipe" data-id="{{$recipe->id}}"><span class="icon-dark mt-2"><i class="far fa-trash-alt"></i></span></a>
    </div>
    @endif
    @endauth

    <div class="modal fade" id="deleteRecipe" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header mx-auto">
                    <h4 class="modal-title" id="exampleModalToggleLabel">¿Seguro que quieres borrar esta receta?</h4>
                </div>
                <div class="modal-footer justify-content-around">
                    <button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal">Volver</button>

                    <form id="formularioBorrado" action="{{ route('receta.destroy', $recipe->id) }}" data-action="{{ route('receta.destroy', 0) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-lg">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="carouser-receta" class="carousel mx-auto" data-ride="carousel">
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

        <a class="carousel-control-prev" href="#carouser-receta" data-slide="prev"><i class="fas fa-angle-left"></i></a>
        <a class="carousel-control-next" href="#carouser-receta" data-slide="next"><i class="fas fa-angle-right"></i></a>
    </div>

    <h3 class="mt-4">Descripción: </h3>
    <div class="texto-receta">
        <p class="text-break">{{$recipe->description}}</p>
    </div>

    <h3 class="mt-4">Ingredientes: </h3>
    <div class="texto-receta text-break" id="ingredients" value="{{$recipe->ingredients}}">
    </div>

    <h3 class="mt-4">Preparación: </h3>
    <div class="texto-receta text-break" id="preparation" value="{{$recipe->preparation}}">
    </div>
    @auth
    @if(Auth::user()->rol_id == '1' || Auth::user()->rol_id == '2')
    <a href="" data-dismiss="modal" data-toggle="modal" data-target="#hideRecipe" data-id="{{$recipe->id}}">Ocultar esta receta de la web por contendio inapropiado.</a>

    <div class="modal fade" id="hideRecipe" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header mx-auto">
                    <h4 class="modal-title" id="exampleModalToggleLabel">¿Seguro que quieres borrar esta receta?</h4>
                </div>
                <div class="modal-footer justify-content-around">
                    <button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal">Volver</button>

                    <form id="formularioHide" action="{{route('receta.hide', $recipe->id)}}" data-action="{{ route('receta.hide', 0) }}" method="get">
                        <button type="submit" class="btn btn-danger btn-lg">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endauth
    
    <h4 class="mt-5">Comentarios: </h4>
    <div class="row">
        <div class="col-md-6">
            @if (Auth::check())
            <form id="regiration_form" novalidate action="{{route('comment.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <textarea class="form-control mb-4" name="text" id="text-comment" rows="4">{{old('text')}}</textarea>
                <input type="hidden" name="recipe_id" id="recipe-comment" value="{{$recipe->id}}">
                <input id="send-comment" user-name="{{ auth()->user()->nickname }}" time="" type="button" value="Publicar comentario" class="align-self-end btn btn-primary" />
                <div id="char-limit"></div>
            </form>
            @else
            <p>Debes estar registrado para comentar en las recetas...</p>
            @endif
        </div>
        <div id="comments" class="col-md-6" style="height: 500px;overflow:auto;">
            @forelse ($recipe->comments->sortByDesc('created_at') as $comment)
            <p class="text-primary fw-bold d-inline-block">{{ $comment->user->nickname }} </p>
            <small class="d-inline-block text-right" style="width: 90%;">{{Carbon\Carbon::parse($comment->created_at)->format('H:i d-m-Y')}}</small>
            <p>{{ $comment->text }}</p>
            <hr>
            @empty
            <p>Aun no hay comentarios para esta receta...</p>
            @endforelse
        </div>
    </div>

</div>
@endsection
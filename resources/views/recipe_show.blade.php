@extends('layouts.app')
@section('content')
<div class="container">
    <div class="d-flex align-items-end">
        <h1 class="titulo-receta d-inline-block text-break">
            {{$recipe->title}}
        </h1>
        <a class="text-primary mb-2 ml-2" href="{{route('perfil.show', $recipe->user->nickname)}}"> by {{$recipe->user->nickname}}</a>
        @auth
        @if (Auth::user()->id == $recipe->user_id)
        <a class="ml-auto" href="{{route('receta.edit', $recipe->slug)}}"><span class="icon-dark mt-2"><i class="far fa-edit"></i></span></a>
        <a type="button" data-dismiss="modal" class="ml-3" data-toggle="modal" data-target="#deleteRecipe" data-id="{{$recipe->id}}"><span class="icon-dark mt-2"><i class="far fa-trash-alt"></i></span></a>
        @endif
        @endauth
    </div>
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
    <script>
        window.onload = function() {
            $('#deleteRecipe').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var id = button.data('id') 
                var modal = $(this)
                // modal.find('.modal-title').text('Olvidando criptomoneda con identificador: ' + id)

                accion = $("#formularioBorrado").attr("data-action").slice(0, -1) + id
                $("#formularioBorrado").attr('action', accion)
            })
        }
    </script>
    <div id="carouser-receta" class="carousel mx-auto" data-ride="carousel">

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
        <p class="text-break">{{$recipe->description}}</p>
    </div>

    <h3 class="mt-4">Ingredientes: </h3>
    <div class="texto-receta text-break" id="ingredients" value="{{$recipe->ingredients}}">
    </div>

    <h3 class="mt-4 text-break">Preparación: </h3>
    <div class="texto-receta" id="preparation" value="{{$recipe->preparation}}">
    </div>
    @auth
    @if(Auth::user()->rol_id == '1' || Auth::user()->rol_id == '2')
    <a href="{{route('receta.hide', $recipe->id)}}">Ocultar esta receta de la web por contendio inapropiado.</a>
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
                <input type="button" value="Publicar comentario" onclick="send_comment()" class="align-self-end btn btn-primary" />
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
@auth
<script>
    function send_comment() {
        const url = '/receta/comment';
        const text = document.getElementById('text-comment').value;
        const recipe_id = document.getElementById('recipe-comment').value;
        const data = new URLSearchParams();
        data.append('_token', '{{ csrf_token() }}');
        data.append('text', text);
        data.append('recipe_id', recipe_id);
        console.log(text)
        fetch(url, {
            method: "POST",
            body: data,
        }).then(function(res) {
            $('#comments').prepend('<p class="text-primary fw-bold d-inline-block">{{ auth()->user()->nickname }} </p><small class="d-inline-block text-right" style="width: 90%;">{{Carbon\Carbon::parse($comment->created_at ?? "")->format("H:i d-m-Y")}}</small><p>' + text + '</p><hr>')
        })
    }
</script>
@endauth
<script>
    document.getElementById('ingredients').innerHTML = document.getElementById('ingredients').getAttribute('value')
    document.getElementById('preparation').innerHTML = document.getElementById('preparation').getAttribute('value')

    $("#text-comment").on('keypress', function() {
        var limit = 150;
        $("#text-comment").attr('maxlength', limit);
        var init = $(this).val().length;

        if (init < limit) {
            init++;
            $('#char-limit').text(init + '/' + limit);
        }
    });
</script>
@endsection
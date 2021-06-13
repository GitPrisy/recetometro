@if ($recipes->count() > 0)
@foreach ($recipes as $key=>$recipe)

<div class="card card-h d-none d-lg-flex">
    <div class="card-img-body">
        <a href={{ route('receta.show', $recipe->slug ?? '') }}><img class="card-img" src="/{{$recipe_images[$key]}}" alt="Imagen destacada de la receta: {{$recipe->title}}" width="300" height="255" /></a>
    </div>
    <div class="card-body">
        <h4 class="card-title desktop-title">{{$recipe->title}}</h4>
        <div class="card-text mb-1 desktop-description">
            <p>{{$recipe->description}}</p>
        </div>
        <p>
            <a class="card-text" href={{ route('receta.show', $recipe->slug ?? '') }}>Seguir leyendo...</a>
        </p>

        @auth
        @if (!$recipe_votes[$key]->where('user_id', '=', Auth::user()->id)->first())
        <span role="button" class="icon-primary vote vote-up" recipe-id="{{$recipe->id}}" recipe-votes="{{$n_votes[$key]}}" style="position:absolute;bottom: 8%;"><i class="far fa-heart"></i> {{$n_votes[$key]}}</span>
        @else
        <span role="button" class="icon-primary vote vote-down" recipe-id="{{$recipe->id}}" recipe-votes="{{$n_votes[$key]}}" style="position:absolute;bottom: 8%;"><i class="fas fa-heart"></i> {{$n_votes[$key]}}</span>
        @endif
        @endauth
        
        @guest
        <a href="/register" role="button" class="icon-primary vote text-decoration-none"><i class="far fa-heart"></i> {{$n_votes[$key]}}</a>
        @endguest

        @php
            $created_at = Carbon\carbon::parse($recipe->created_at);
            $today = Carbon\carbon::now();
            $minutes = $created_at->diffInMinutes($today, false);
            $hours = $created_at->diffInHours($today, false);
            $days = $created_at->diffInDays($today, false);
        @endphp

        @if ($minutes < 1) 
        <small class="text-muted card-time" id="votos">Creado recientemente.</small>

        @elseif ($minutes < 60) 
        <small class="text-muted card-time" id="votos">Creado hace {{ $minutes }} minuto/s</small>

        @elseif ($hours < 24) 
        <small class="text-muted card-time" id="votos">Creado hace {{ $hours }} hora/s</small>

        @elseif ($hours >= 24)
        <small class="text-muted card-time" id="votos">Creado hace {{ $days }} día/s</small>
        @endif
    </div>
</div>

<div class="col-12 col-md-6">
    <div class="card d-lg-none">
        <div class="card-img-body">
            <a href={{ route('receta.show', $recipe->slug ?? '') }}><img class="card-img-top img-fluid" src="/{{$recipe_images[$key]}}" alt="Card image cap" /></a>
        </div>
        <div class="card-body">
            <h4 class="card-title">{{$recipe->title}}</h4>
            <div class="card-text mobile-description">
                <p>{{$recipe->description}}</p>
            </div>
            <p>
                <a class="card-text" href={{ route('receta.show', $recipe->slug ?? '') }}>Seguir leyendo...</a>
            </p>

            @auth
            @if (! $recipe_votes[$key]->where('user_id', '=', Auth::user()->id)->first())
            <span role="button" class="icon-primary vote vote-up" recipe-id="{{$recipe->id}}" recipe-votes="{{$n_votes[$key]}}"><i class="far fa-heart"></i> {{$n_votes[$key]}}</span>
            @else
            <span role="button" class="icon-primary vote vote-down" recipe-id="{{$recipe->id}}" recipe-votes="{{$n_votes[$key]}}"><i class="fas fa-heart"></i> {{$n_votes[$key]}}</span>
            @endif
            @endauth

            @guest
            <a href="/register" role="button" class="icon-primary vote text-decoration-none"><i class="far fa-heart"></i> {{$n_votes[$key]}}</a>
            @endguest

            <p class="card-text">
                @php
                    $created_at = Carbon\carbon::parse($recipe->created_at);
                    $today = Carbon\carbon::now();
                    $minutes = $created_at->diffInMinutes($today, false);
                    $hours = $created_at->diffInHours($today, false);
                    $days = $created_at->diffInDays($today, false);
                @endphp

                @if ($minutes < 1) 
                <small class="text-muted card-time" id="votos">Creado recientemente.</small>

                @elseif ($minutes < 60) <small class="text-muted card-time" id="votos">Creado hace {{ $minutes }} minuto/s</small>
                    
                @elseif ($hours < 24) <small class="text-muted card-time" id="votos">Creado hace {{ $hours }} hora/s</small>
                        
                @elseif ($hours >= 24) <small class="text-muted card-time" id="votos">Creado hace {{ $days }} día/s</small>
                @endif
            </p>
        </div>
    </div>
</div>
@endforeach
@else
<h3>Parece que no hay recetas por aquí... </h3>
<p>:(</p>
@endif
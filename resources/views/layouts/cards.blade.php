<script>
    function vote_up(id) {
        const url = '/receta/' + id + '/vote-up';
        const data = new URLSearchParams();
        data.append('_token', '{{ csrf_token() }}');
        fetch(url, {
            method: "POST",
            body: data,
        }).then(function(res) {
            const votos = document.getElementsByClassName('vote');

            for (let i = 0; i < votos.length; i++) {
                let voto = votos[i];
                if (voto.getAttribute('recipe-id') == id) {
                    let card_pair = (votos.length / 2) + i;
                    let recipe_votes = parseInt(voto.getAttribute('recipe-votes')) + 1;
                    let recipe_id = voto.getAttribute('recipe-id');

                    voto.setAttribute('recipe-votes', recipe_votes);
                    voto.setAttribute('onclick', "vote_down(" + recipe_id + ")");
                    voto.innerHTML = "<i class='fas fa-heart'></i> " + recipe_votes;

                    votos[card_pair].setAttribute('recipe-votes', recipe_votes);
                    votos[card_pair].setAttribute('onclick', "vote_down(" + recipe_id + ")");
                    votos[card_pair].innerHTML = "<i class='fas fa-heart'></i> " + recipe_votes;
                }
            }
        })
    }

    function vote_down(id) {
        const url = '/receta/' + id + '/vote-down';
        const data = new URLSearchParams();
        data.append('_token', '{{ csrf_token() }}');
        fetch(url, {
            method: "POST",
            body: data,
        }).then(function(res) {
            const votos = document.getElementsByClassName('vote');

            for (let i = 0; i < votos.length; i++) {
                let voto = votos[i];
                if (voto.getAttribute('recipe-id') == id) {
                    let card_pair = (votos.length / 2) + i;
                    let recipe_id = voto.getAttribute('recipe-id');
                    let recipe_votes = parseInt(voto.getAttribute('recipe-votes')) - 1;

                    voto.setAttribute('recipe-votes', recipe_votes);
                    voto.setAttribute('onclick', "vote_up(" + recipe_id + ")");
                    voto.innerHTML = "<i class='far fa-heart'></i> " + recipe_votes;

                    votos[card_pair].setAttribute('recipe-votes', recipe_votes);
                    votos[card_pair].setAttribute('onclick', "vote_up(" + recipe_id + ")");
                    votos[card_pair].innerHTML = "<i class='far fa-heart'></i> " + recipe_votes;
                }
            }

        })
    }
</script>
@foreach ($recipes as $key=>$recipe)

<!-- Desktop cards -->
<div class="card card-h d-none d-lg-flex">
    <div class="card-img-body">
        <img class="card-img" src="/{{$recipe_images[$key]}}" alt="Card image cap" />
    </div>
    <div class="card-body">
        <h4 class="card-title">{{$recipe->title}}</h4>
        <p class="card-text">
            {{$recipe->preparation}}
            <a class="" href={{ route('receta.show', $recipe) }}>Seguir leyendo...</a>
        </p>
        @auth
        @if (! $recipe_votes[$key]->where('user_id', '=', Auth::user()->id)->first())
        <span role="button" class="icon-primary vote" onclick="vote_up('{{$recipe->id}}')" recipe-id="{{$recipe->id}}" recipe-votes="{{$n_votes[$key]}}">
            <i class="far fa-heart"></i>
            {{$n_votes[$key]}}
        </span>
        @else
        <span role="button" class="icon-primary vote" onclick="vote_down('{{$recipe->id}}')" recipe-id="{{$recipe->id}}" recipe-votes="{{$n_votes[$key]}}">
            <i class="fas fa-heart"></i>
            {{$n_votes[$key]}}
        </span>
        @endif
        @endauth
        @guest
        <a href="/register" role="button" class="icon-primary vote text-decoration-none">
            <i class="far fa-heart"></i>
            {{$n_votes[$key]}}
        </a>
        @endguest
        @php
        $created_at = Carbon\carbon::parse($recipe->created_at);
        $today = Carbon\carbon::now();
        $minutes = $created_at->diffInMinutes($today, false);
        $hours = $created_at->diffInHours($today, false);
        $days = $created_at->diffInDays($today, false);
        @endphp
        @if ($minutes < 1) <small class="text-muted card-time" id="votos">Creado recientemente.</small>
            @elseif ($minutes < 60) <small class="text-muted card-time" id="votos">Creado hace {{ $minutes }} minuto/s</small>
                @elseif ($hours < 24) <small class="text-muted card-time" id="votos">Creado hace {{ $hours }} hora/s</small>
                    @elseif ($hours >= 24)
                    <small class="text-muted card-time" id="votos">Creado hace {{ $days }} día/s</small>
                    @endif
    </div>
</div>


<!-- Mobile cards -->
<div class="col-12 col-md-6">
    <div class="card d-lg-none">
        <div class="card-img-body">
            <img class="card-img-top" src="/{{$recipe_images[$key]}}" alt="Card image cap" />
        </div>
        <div class="card-body">
            <h4 class="card-title">{{$recipe->title}}</h4>
            <p class="card-text">
                {{Str::limit($recipe->preparation, 240) }}
                <br>
                <a class="card-text" href={{ route('receta.show', $recipe->slug ?? '') }}>Seguir leyendo...</a>
            </p>
            @auth
            @if (! $recipe_votes[$key]->where('user_id', '=', Auth::user()->id)->first())
            <span role="button" class="icon-primary vote" onclick="vote_up('{{$recipe->id}}')" recipe-id="{{$recipe->id}}" recipe-votes="{{$n_votes[$key]}}">
                <i class="far fa-heart"></i>
                {{$n_votes[$key]}}
            </span>
            @else
            <span role="button" class="icon-primary vote" onclick="vote_down('{{$recipe->id}}')" recipe-id="{{$recipe->id}}" recipe-votes="{{$n_votes[$key]}}">
                <i class="fas fa-heart"></i>
                {{$n_votes[$key]}}
            </span>
            @endif
            @endauth
            @guest
            <a href="/register" role="button" class="icon-primary vote text-decoration-none">
                <i class="far fa-heart"></i>
                {{$n_votes[$key]}}
            </a>
            @endguest
            <p class="card-text">
                @php
                $created_at = Carbon\carbon::parse($recipe->created_at);
                $today = Carbon\carbon::now();
                $minutes = $created_at->diffInMinutes($today, false);
                $hours = $created_at->diffInHours($today, false);
                $days = $created_at->diffInDays($today, false);
                @endphp
                @if ($minutes < 1) <small class="text-muted card-time" id="votos">Creado recientemente.</small>
                    @elseif ($minutes < 60) <small class="text-muted card-time" id="votos">Creado hace {{ $minutes }} minuto/s</small>
                        @elseif ($hours < 24) <small class="text-muted card-time" id="votos">Creado hace {{ $hours }} hora/s</small>
                            @elseif ($hours >= 24)
                            <small class="text-muted card-time" id="votos">Creado hace {{ $days }} día/s</small>
                            @endif
            </p>
        </div>
    </div>
    <div class="d-lg-none">
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- robasimple -->
        <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-3650069535362055" data-ad-slot="2858588044" data-ad-format="auto" data-full-width-responsive="true"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>
</div>

<div class="d-lg-none">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <!-- robasimple -->
    <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-3650069535362055" data-ad-slot="2858588044" data-ad-format="auto" data-full-width-responsive="true"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
</div>
@endforeach
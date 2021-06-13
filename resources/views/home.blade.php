@extends('layouts.app')
@section('content')
<nav class="navbar navbar-dark bg-primary">
    <div class="container-fluid justify-content-around">
        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMean" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Modos de preparación
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMean">
                <form action="{{ route('receta.search') }}" method="GET">
                    @foreach($means as $mean)
                    <button class="dropdown-item" type="submit" name="preparacion" value="{{ $mean->slug }}">{{$mean->name}}</button>
                    @endforeach
                </form>
            </div>
        </div>
        <div class="dropdown">
            <p class="fw-bold text-light mb-0 dropdown-toggle" type="button" id="dropdownTag" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Características
            </p>
            <div class="dropdown-menu dropdown-menu-center" aria-labelledby="dropdownTag">
                <form action="{{ route('receta.search') }}" method="GET">
                    @foreach($tags as $tag)
                    <button class="dropdown-item" type="submit" name="tag" value="{{ $tag->slug }}">{{$tag->name}}</button>
                    @endforeach
                </form>
            </div>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row" id="post-data" pages="{{$recipes->lastPage()}}">
        @include('layouts.cards')
    </div>

    <div class="auto-load text-center my-3" style="display: none">
        <img src="{{asset('images/logos/loading-buffering.gif')}}" alt="Cargando..." width="60" height="60">
    </div>
</div>
@endsection
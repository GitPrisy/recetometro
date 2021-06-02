@extends('layouts.app')
@section('content')
<link href="{{ asset('css/profile.css') }}" rel="stylesheet">
<div class="container emp-profile">
    <form method="post">
        <div class="row">
            <div class="col">
                <div class="profile-img">
                    @if($user->profile_image == '')
                    <img src="/images/user/default-user.png" alt="" style="width: 200px;" />
                    @else
                    <img src="/images/user/{{$user->profile_image}}" alt="" style="width: 200px;" />
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="profile-head">
                    <h2 class='text-center mt-3'>
                        {{$user->name}}
                    </h2> 
                </div>
            </div>
            
        </div>
        <div class="row mt-4">
            <div class="col-md-12 text-center">
                <div class="profile-head">
                    <p class="proile-rating">
                        Recetas: <span class='mr-5'>{{$n_recipes}}</span>
                        Votos: <span>{{$n_votes}}</span>
                    </p>
                </div>
            </div>
            
        </div>
        <div class="row mt-2">
            <div class="col-md-6 text-center">
                <a class="btn profile-edit-btn mt-3" href="{{route('perfil.edit', $user->nickname)}}">Editar perfil</a>
            </div>
            <div class="col-md-6 text-center">
                @if($n_recipes == 0)
                <a class="btn profile-edit-btn mt-3" href="{{route('receta.create')}}">Crear primera receta</a>
                @else
                <a class="btn profile-edit-btn mt-3" href="{{route('perfil.show', $user->nickname)}}">Ver recetas</a>
                @endif
            </div>
        </div>
        <div class="row mt-4">
            <div class="col">
                <div class="tab-content profile-tab" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="row mt-2">
                            <div class="col-12">
                                <label>Nombre de usuario: </label>
                            </div>
                            <div class="col">
                                <p>{{$user->nickname}}</p>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <label>Nombre: </label>
                            </div>
                            <div class="col">
                                <p>{{$user->name}}</p>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <label>Correo: </label>
                            </div>
                            <div class="col">
                                <p>{{$user->email}}</p>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

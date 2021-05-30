@extends('layouts.app')
@section('content')
<style>

.emp-profile{
    margin: auto;
    border-radius: 1rem;
    box-shadow: rgba(0, 0, 0, 0.1) 0px 20px 25px -5px, rgba(0, 0, 0, 0.04) 0px 10px 10px -5px;
    background: var(--white);
    padding: 2rem;
}

.profile-img{
    text-align: center;
}

.profile-img img{
    width: 70%;
    height: 100%;
}

.profile-img .file {
    position: relative;
    overflow: hidden;
    margin-top: -20%;
    width: 70%;
    border: none;
    border-radius: 0;
    font-size: 15px;
    background: #212529b8;
}

.profile-img .file input {
    position: absolute;
    opacity: 0;
    right: 0;
    top: 0;
}

.profile-edit-btn{
    font-size: 1rem;
    border: none;
    border-radius: 1.5rem;
    width: 70%;
    font-weight: 600;
    box-shadow: rgba(0, 0, 0, 0.1) 0px 20px 25px -5px, rgba(0, 0, 0, 0.04) 0px 10px 10px -5px;
    color: var(--secondary);
    cursor: pointer;
}

.proile-rating{
    font-size: 1rem;
    color: var(--secondary);
}
.proile-rating span{
    color: var(--dark);
    font-size: 15px;
    font-weight: 600;
}
.profile-tab label{
    font-weight: 600;
}
.profile-tab p{
    font-weight: 600;
    color: var(--primary);
}
</style>
<div class="container emp-profile">
    <form method="post">
        <div class="row">
            <div class="col">
                <div class="profile-img">
                    <img src="https://i.redd.it/v0m2c7uswae11.png" alt="" />
                    <div class="file btn btn-lg btn-primary">
                        Cambiar foto
                        <input type="file" name="file" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="profile-head">
                    <h2 class='text-center'>
                        {{$user->name}}
                    </h2> 
                </div>
            </div>
            
        </div>
        <div class="row mt-4">
            <div class="col-md-8 text-center">
                <div class="profile-head">
                    <p class="proile-rating">
                        Recetas: <span class='mr-5'>{{$n_recipes}}</span>
                        Votos: <span>{{$n_votes}}</span>
                    </p>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <input type="submit" class="profile-edit-btn" name="btnAddMore" value="Editar Perfil" />
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-4 text-center">
                <a class="btn profile-edit-btn mt-2" href="{{route('perfil.show', $user->nickname)}}">Ver recetas</a>
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
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="width: 90%">
                <div class="card-header bg-primary text-light">Inicio de sesión</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Correo electrónico</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Contraseña</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                <span role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                    <p>
                                        <a href="{{ route('password.request') }}">¿No recuerdas tu contraseña?</a>
                                    </p>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        Iniciar sesión utomáticamente.
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-4 col-md-4 offset-md-4 mt-3">
                                <button type="submit" class="btn btn-primary">
                                    Continuar
                                </button>
                            </div>
                            <div class="col-12 col-sm-8 col-md-7 mt-3 offset-md-4 d-md-inline-block d-sm-flex justify-content-end">
                                <a href="{{route('login.social', 'google')}}" class="btn btn-outline-secondary"><img alt="Google" title="Sign in with Google" class="mr-3" width="20px" src="{{ asset('images/logos/google_logo.png') }}" loading="lazy">Continuar con Google</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
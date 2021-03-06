@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card" style="width: 90%">
                    <div class="card-header bg-primary text-light">Registro</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Nombre</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="nickname" class="col-md-4 col-form-label text-md-right">Apodo</label>

                                <div class="col-md-6">
                                    <input id="nickname" type="text"
                                        class="form-control @error('nickname') is-invalid @enderror" name="nickname"
                                        value="{{ old('nickname') }}" required autocomplete="nickname" autofocus>

                                    @error('nickname')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">Correo electr??nico</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label form-check-label text-md-right">Recibir
                                    correos</label>
                                <div class="col-8">
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input id='mailableHidden' type='hidden' value='0' name='mailable'>
                                        <input name="mailable" id="mailable" type="checkbox"
                                            class="custom-control-input" value="1">
                                        <label for="mailable" class="custom-control-label"></label>
                                    </div>
                                    <script>
                                        document.getElementById("mailable").addEventListener('change', (event) => {
                                            if (event.currentTarget.checked) {
                                                document.getElementById("mailableHidden").disabled = true;
                                            } else {
                                                document.getElementById("mailableHidden").disabled = false;
                                            }
                                        })
                                    </script>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Contrase??a</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirmar
                                    contrase??a</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-4 col-md-4 offset-md-4 mt-3">
                                    <button type="submit" class="btn btn-primary">
                                        Continuar
                                    </button>
                                </div>
                                <div class="col-12 col-sm-8 col-md-7 mt-3 offset-md-4 d-md-inline-block d-sm-flex justify-content-end">
                                    <a href="{{route('login.social', 'google')}}" class="btn btn-outline-secondary">
                                        <img alt="Google" title="Sign in with Google" class="mr-3" width="20px" src="{{ asset('images/logos/google_logo.png') }}" loading="lazy">
                                        Continuar con Google
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

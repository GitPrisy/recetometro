@extends('layouts.app')
@section('content')
<link href="{{ asset('css/profile.css') }}" rel="stylesheet">
<script>
    function change_image(nickname) {
        const url = '/perfil/' + nickname + '/edit';
        const data = new URLSearchParams();
        data.append('_token', '{{ csrf_token() }}');
        fetch(url, {
            method: "PUT",
            body: data,
        })
    }
</script>
<div class="container emp-profile">
    <form id="profile_update" method="post" action="{{ route('perfil.update', $user->nickname) }}" enctype="multipart/form-data">
    @method('PUT')

    @csrf

        <div class="row">
            <div class="col-12">
                <div class="profile-img">
                    @if($user->profile_image == '')
                    <img src="/images/user/default-user.png" alt="" style="width: 200px;" />
                    @else
                    <img src="/images/user/{{$user->profile_image}}" alt="" style="width: 200px;" />
                    @endif
                </div>
            </div>
            <div class="col">
                <div class="profile-img">
                    <div class="file btn btn-lg btn-primary">
                    Cambiar foto
                    <input id="profile_image" type="file" accept="image/png, image/gif, image/jpeg, image/jpg"  name="profile_image" />
                </div>
                <script>
                    document.getElementById("profile_image").onchange = function() {
                        document.getElementById("profile_update").submit();
                    };
                </script>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="col-12 profile-head">
                    <input type="text" class="form-control-plaintext" name="nickname" value="{{$user->nickname}}">
                </div>
                @error('nickname')
                    <span>
                        <strong class="text-danger">{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            
        </div>

        <div class="row mt-4">
            <div class="col">
                <div class="tab-content profile-tab" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="row mt-4">
                            <div class="col-12">
                                <label for="name">Nombre completo: </label>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control-plaintext pl-2" name="name" id="name" value="{{$user->name}}">
                            </div>
                            @error('name')
                                <span>
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="row mt-4">
                            <div class="col-12">
                                <label for="email">Correo: </label>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control-plaintext pl-2" name="email" id="email" value="{{$user->email}}">
                            </div>
                            @error('email')
                                <span>
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <label>Notificaciones</label>
                                <div class="custom-control custom-checkbox custom-control-inline align-midle">
                                    <input id='mailableHidden' type='hidden' value='0' name='mailable'>
                                    @if ($user->mailable == 1)
                                    <input name="mailable" id="mailable" type="checkbox" class="custom-control-input" value="1" checked>
                                    @else
                                    <input name="mailable" id="mailable" type="checkbox" class="custom-control-input" value="1">
                                    @endif
                                    <label for="mailable" class="custom-control-label ml-2 mt-1"></label>
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
                            @error('mailable')
                                <span>
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-6 text-center">
                <button type="submit" class="btn profile-edit-btn mt-3">Guardar cambios</button>
            </div>
            <div class="col-md-6 text-center">
                <a class="btn profile-edit-btn mt-3" href="{{route('perfil.index', $user->nickname)}}">Volver al perfil</a>
            </div>
        </div>
    </form>
</div>
@endsection

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'nickname' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'mailable' => ['required', 'boolean'],
            'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/', 'confirmed'],
        ], 
        [
            'name.required' => 'Debes rellenar el campo de nombre...',
            'name.max' =>'El nombre no puede ser superior a :max caracteres...',
            'nickname.required' => 'Debes rellenar el campo de nombre de usuario...',
            'nickname.max' => 'El nombre de usuario no puede ser superior a :max caracteres...',
            'nickname.unique' => 'Lo siento, ese nombre de usuario ya existe...',
            'email.required' => 'Debes rellenar el campo de correo electr??nico...',
            'email.email' => 'El correo debe ser v??lido...',
            'email.unique' => 'Ya existe un usuario con ese correo...',
            'password.required' => 'Debes rellenar el campo de la contrase??a...',
            'password.min' => 'La contrase??a debe tener m??nimo :min caracteres...',
            'password.regex' => 'La contrase??a debe tener 8 caracteres con por lo menos un n??mero, una letra y un car??cter especial...',
            'password.confirmed' => 'Las contrase??as no coinciden...',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'nickname' => $data['nickname'],
            'email' => $data['email'],
            'mailable' => $data['mailable'],
            'password' => Hash::make($data['password']),
        ]);
    }
}

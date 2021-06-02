<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreProfilePost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Debes ponerle un título a la receta...',
            'name.max' =>'El título debe tener entre :min y :max caracteres...',
            'nickname.required' => 'Debes rellenar el campo de nombre de usuario...',
            'nickname.max' => 'El nombre de usuario no puede ser superior a :max caracteres...',
            'nickname.unique' => 'Lo siento, ese nombre de usuario ya existe...',
            'email.required' => 'Debes rellenar el campo de correo electrónico...',
            'email.email' => 'El correo debe ser válido...',
            'email.unique' => 'Ya existe un usuario con ese correo...',
            'password.required' => 'Debes rellenar el campo de la contraseña...',
            'password.regex' => 'La contraseña debe tener mínimo :min caracteres...',
            'password.regex' => 'La contraseña debe tener 8 caracteres con por lo menos un número, una letra y un carácter especial...',
            'password.confirmed' => 'Las contraseñas no coinciden...',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:4|max:100',
            'nickname' => 'required|min:4|max:100',
            'nickname' => Rule::unique('users')->ignore(Auth::user()),
            'email' => 'required|min:10|email|unique:users',
            'email' => Rule::unique('users')->ignore(Auth::user()),
            'mailable' => 'required|boolean',
            'profile_image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:15360',
        ];
    }
}

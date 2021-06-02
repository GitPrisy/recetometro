<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecipePost extends FormRequest
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
            'title.required' => 'Debes ponerle un título a la receta...',
            'title.min' =>'El título debe tener entre :min y :max caracteres...',
            'title.max' =>'El título debe tener entre :min y :max caracteres...',
            'description.required' => 'Debes hacer una pequeña descripción de la receta...',
            'description.max' => 'La descripción no puede superar los :max caracteres...',
            'ingredients.required' => 'Debes hacer una lista de ingredientes para la receta...',
            'ingredients.min' => 'La lista de ingredeintes debe tener al menos :min caracteres...',
            'preparation.required' => 'Debes explicar detalladamente la elaboración de la receta...',
            'preparation.min' => 'La elaboración debe ser detallada, por lo que son necesarios como mínimo :min caracteres...',
            'tag.required' => 'Selecciona por lo menos una etiqueta que represente tu receta...',
            'file.*.mimes' => 'El formato de la imagen no es válido (jpg, png, jpeg, gif)...',
            'file.*.max' => 'Los archivos ocupan demasiado espacio, prueba con algo más pequeño...',
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
            'title' => 'required|min:5|max:90',
            'description' => 'required|max:250',
            'ingredients' => 'required|min:30',
            'preparation' => 'required|min:100',
            'tag' => 'required|array|min:1',
            'tag.*' => 'exists:tags,id',
            'mean' => 'required|exists:means,id',
            'file' => 'nullable|array',
            'file.*' => 'nullable|mimes:jpeg,png,jpg,gif|max:15000',
        ];
    }
}

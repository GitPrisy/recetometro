<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfilePut extends FormRequest
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
            'nickname.required' => 'Debes poinerwefoiqw ..',
            'nickname.min' =>'El título debe tener entre :min y :max caracteres...',
            'nickname.max' =>'El título debe tener entre :min y :max caracteres...',
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
            'nickname' => 'required|min:5|max:90',
        ];
    }
}

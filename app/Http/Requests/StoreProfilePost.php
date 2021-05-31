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

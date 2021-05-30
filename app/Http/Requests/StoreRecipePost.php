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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|min:5|max:100',
            'description' => 'required|max:100',
            'ingredients' => 'required|min:30',
            'preparation' => 'required|min:100',
            'tag' => 'required|array|min:1',
            'tag.*' => 'exists:tags,id',
            'mean' => 'required|exists:means,id',
            'file' => 'nullable|array',
            'file.*' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:15360',
        ];
    }
}

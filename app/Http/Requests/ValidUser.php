<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidUser extends FormRequest
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
            'name' => 'required|between:3,50',
            'email' => 'required|unique:users,email,'. request()->user .',id|between:5,100',
            'photo' => 'image|mimes:jpeg,png,bmp,jpg,gif,svg|max:2048|dimensions:min_width=100,min_height=100'
        ];
    }
}

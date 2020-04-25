<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\User;

class ValidUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $can = false;
        switch ($this->route()->getName()) {
            case 'users.store': 
                $can = true; 
            break;
            case 'users.update': 
                $can = auth()->check() && auth()->user()->can('update', User::findOrFail($this->user)); 
            break;
        }
        return $can;
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

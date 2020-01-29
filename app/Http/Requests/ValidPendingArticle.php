<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidPendingArticle extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
        //erorare
        if (strtolower(request()->_method) === 'put') {
            return auth()->user() && auth()->user()->can('update', \App\Article::firstOrFail( request()->id ));
        } else {
            return auth()->user() && auth()->user()->can('create', \App\Article::class);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'bible_version_id' => 'required',
            'book_index' => 'required',
            'language' => 'required|between:3,15',
            'title' => 'required',
            'content' => 'required',
            'tags' => 'required'
        ];
    }
}

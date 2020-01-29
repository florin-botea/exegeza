<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class Book extends FormRequest
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
    public function rules(Request $request)
    {
				$bible = \App\BibleVersion::findOrFail($request->route('bible_version'));
				$isUpdating = \App\Book::find($request->book);
				$isCreating = !$isUpdating;
				$isIndexUpdate = $isUpdating && $isUpdating->index != $request->index;
				$isAliasUpdate = $isUpdating && strtolower($isUpdating->alias) != strtolower($request->alias);
				$isIndexPresent = $bible->books()->where('index', $request->index)->first();
				$isAliasPresent = $bible->books()->where('alias', $request->alias)->first();
				$indexRule = (($isUpdating&&!$isIndexUpdate)||($isUpdating&&!$isIndexPresent)||($isCreating&&!$isIndexPresent)) ? '' : '|unique:books,index';
				$aliasRule = (($isUpdating&&!$isAliasUpdate)||($isUpdating&&!$isAliasPresent)||($isCreating&&!$isAliasPresent)) ? '' : '|unique:books,alias';

        return [
            'index' => 'required|integer|min:1'.$indexRule,
						'name' => 'required|between:3,100',
						'alias' => 'required|between:2,100'.$aliasRule,
						'type' => ['required', 'regex:/(vt|nt|altele)/']		
        ];
    }
}

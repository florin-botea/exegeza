<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class Chapter extends FormRequest
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
				$isUpdating = \App\Chapter::find($request->chapter);
				$isCreating = !$isUpdating;
				$isIndexUpdate = $isUpdating && $isUpdating->index != $request->index;
				$isIndexPresent = \App\BibleVersion::findOrFail($request->bible_version)
						->books()->findOrFail($request->book)
						->chapters()->where('index', $request->index)->first();
				$noIndexConflict = ($isUpdating&&!$isIndexUpdate)||($isCreating&&!$isIndexPresent)||($isUpdating&&!$isIndexPresent);
				$indexRule = ($noIndexConflict) ? '' : '|unique:chapters,index';
				$rules = [
            'index' => 'required|integer|min:1'.$indexRule,
						'name' => 'required|between:3,100',
				];
				if ($request->add_verses) {
						$rules['regex'] = 'required|regex:/\/.+\/$/i';
						$rules['verses'] = 'required';
				}
				
        return $rules;
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ValidChapter extends FormRequest
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
     * Manage complexity of unique fields rules
     */
	public function withValidator($validator)
	{
		$validator->after(function ($validator) {
            $bible = BibleVersion::findOrFail(request()->route('bible_version'));
            $book = $bible->book()->findOrFail(request()->route('book'));
			$duplicateIndex = $book->chapters()->where('index', request()->input('index'))->first();
			if ($duplicateIndex && !request()->isMethod('put')) {
				$validator->errors()->add('index', 'Index already taken');
			}
		});
	}
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        $rules = [
            'index' => 'required|integer|min:1',
            'name' => 'required|between:3,100',
        ];
        if ($request->add_verses) {
            $rules['regex'] = 'required|regex:/\/.+\/$/i';
            $rules['verses'] = 'required';
        }

        return $rules;
    }
}

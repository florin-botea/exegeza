<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ValidBook extends FormRequest
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
            $bible = \App\BibleVersion::findOrFail(request()->route('bible_version'));
			$duplicateIndex = $bible->books()->where(['index' => request()->input('index'), 'type' => request()->input('type')])->first();
			$duplicateAlias = $bible->books()->where(['alias' => request()->input('alias'), 'type' => request()->input('type')])->first();
			if ($duplicateIndex && !request()->isMethod('put')) {
				$validator->errors()->add('index', 'Index already taken');
			}
			if ($duplicateAlias && !request()->isMethod('put')) {
				$validator->errors()->add('alias', 'Alias already taken');
			}
		});
	}

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'index' => 'required|integer|min:1',
            'name' => 'required|between:3,100',
            'alias' => 'required|between:2,100',
            'type' => ['required', 'regex:/(vt|nt|altele)/']		
        ];
    }
}

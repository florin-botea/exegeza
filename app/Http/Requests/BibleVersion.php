<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class BibleVersion extends FormRequest
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
	
	protected function getValidatorInstance ()
	{
		if (!$this->public) {
			$post = $this->all();
			$this->public ? '' : $post['public'] = 0;
			$this->replace($post);
		}
		
		return parent::getValidatorInstance();
	}

	public function withValidator($validator)
	{
		$validator->after(function ($validator) {
			$duplicateIndex = \App\BibleVersion::where('index', request()->input('index'))->first();
			$duplicateAlias = \App\BibleVersion::where('alias', request()->input('alias'))->first();
			if ($duplicateIndex) {
				$validator->errors()->add('index', 'Index already taken');
			}
			if ($duplicateAlias) {
				$validator->errors()->add('alias', 'Alias already taken');
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
		return [
			'index' => 'required|integer|min:1',
			'name' => 'required|between:3,100',
			'alias' => 'required|between:2,100',
			'language' => 'required|between:1,100'
		];
	}
}

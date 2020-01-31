<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ValidBibleVersion extends FormRequest
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
	/*
	protected function getValidatorInstance ()
	{
		if (!$this->public) {
			$post = $this->all();
			$this->public ? '' : $post['public'] = 0;
			$this->replace($post);
		}
		
		return parent::getValidatorInstance();
	}*/

	public function withValidator($validator)
	{
		$validator->after(function ($validator) {
			$duplicateIndex = \App\BibleVersion::where('index', Input::get('index'))->first();
			$duplicateAlias = \App\BibleVersion::where('alias', Input::get('alias'))->first();
			if ($duplicateIndex && !request()->isMethod('put')) {
				$validator->errors()->add('index', 'Index already taken');
			}
			if ($duplicateAlias && !request()->isMethod('put')) {
				$validator->errors()->add('alias', 'Alias already taken');
			}
			
			if ($validator->errors()->any() && Input::has('form_id')) {
				return back()
					->withErrors($validator, Input::get('form_id'));
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

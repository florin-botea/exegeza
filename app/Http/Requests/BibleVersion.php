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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
				$bibleVersion = \App\BibleVersion::find($request->route('bible_version'));// ?? \App\BibleVersion::withTrashed()->where('index', $request->index)->first();
				$index = $bibleVersion ? '' : '|unique:bible_versions';
				$alias = $bibleVersion ? '' : '|unique:bible_versions';

				return [
            'index' => 'required|integer|min:1'.$index,
						'name' => 'required|between:3,100',
						'alias' => 'required|between:2,100'.$alias,
						'lang' => 'required|between:1,100'
        ];
    }
}

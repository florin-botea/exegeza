<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Article;

class ValidArticle extends FormRequest
{
    public function authorize()
    {
        if (!auth()->user()) return false;
        switch ( $this->route()->getName() ) {
            case 'articles.store': return auth()->user()->can('create', Article::class);
            break;
            case 'articles.update': return $this->canUpdateArticle(Article::findOrFail($this->article));
            break;
        }
        return true;
    }

	protected function getValidatorInstance()
	{
        if ($this->isPosting() || ($this->isPosting() && $this->isPublishing())) {
            $article = $this->all();
            $article['user_id'] = auth()->user()->id;
            $this->replace($article);
        }
		
		return parent::getValidatorInstance();
	}
    
    public function rules()
    {
        $rules = [
            'bible_version_id' => 'required',
            'book_index' => 'required',
            'book_id' => 'required',
            'language' => 'required|between:3,15',
            'title' => 'required',
            'content' => 'required',
            'tags' => 'required'
        ];
        if ($this->isPublishing()) {
            $rules = array_merge($rules, [
                'meta' => 'required|between:70,155',
                'sample' => 'required',
                'cite_from' => 'sometimes|max:61'
            ]);
        }
        return $rules;
    }

	public function withValidator($validator)
	{
		$validator->after(function ($validator) {
            $duplicate_title = \App\Article::where([
                'user_id' => auth()->user()->id, 
                'slug' => $this->slug
            ])->first();

            if ($this->isPosting() && $duplicate_title) {
                $validator->errors()->add('title', 'Title already taken');
            }
		});
	}

    private function isPublishing()
    {
        return $this->route()->getName() === 'articles.publish';
    }

    private function isPosting()
    {
        return $this->route()->getName() === 'articles.store' || !isset($this->article);
    }

    private function canUpdateArticle(Article $article)
    {
        return (auth()->user()->can('update', $article) || $article->user_id === auth()->user()->id);
    }
}

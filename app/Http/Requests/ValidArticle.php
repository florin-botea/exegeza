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
        $article = $this->all();
        if ($this->isPosting() || ($this->isPosting() && $this->isPublishing()))
            $article['user_id'] = auth()->user()->id;
        if ($this->isPublishing()) {
            $article['published_by'] = auth()->user()->id;
        } elseif ($this->isUpdating()) {
            $article['published_by'] = null;
        }
        $this->replace($article);
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
            'tags' => 'required',
            'cite_from' => 'sometimes|max:61'
        ];
        if ($this->isPublishing()) {
            $rules = array_merge($rules, [
                'meta' => 'required|between:70,155',
                'sample' => 'required',
            ]);
        }
        return $rules;
    }

	public function withValidator($validator)
	{
		$validator->after(function ($validator) {
            $duplicate_title = Article::where([
                'user_id' => auth()->user()->id,
                'slug' => $this->slug
            ])->first();

            if ($this->isPosting() && $duplicate_title) {
                $validator->errors()->add('title', 'Aveti deja postari cu acest titlu. Va rugam sa selectati un alt titlu.');
            }
		});
	}

    private function isPublishing()
    {
        return $this->route()->getName() === 'articles.publish';
    }

    private function isPosting()
    {
        return $this->route()->getName() === 'articles.store' || $this->article == 0;
    }

    private function isUpdating()
    {
        return $this->route()->getName() === 'articles.update';
    }

    private function canUpdateArticle(Article $article)
    {
        return (auth()->user()->can('update', $article) || $article->user_id === auth()->user()->id);
    }
}

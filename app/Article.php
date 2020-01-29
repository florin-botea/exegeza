<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Article extends Model
{
	protected $fillable = ['bible_version_id', 'book_index', 'chapter_index', 'user_id', 'meta', 'title', 'slug', 'sample', 'content', 'translation_of', 'published_by'];

	public function original()
	{
		return $this->hasOne(\App\Article::class, 'translation_of');
	}

	public function author()
	{
		return $this->hasOne(\App\User::class, 'id', 'user_id');
	}

	public function bible()
	{
		return $this->belongsTo(\App\BibleVersion::class, 'bible_version_id')->with(['book' => function($q) {
			return $q->where('index', DB::raw('article.book_index'));
		}]);
	}

	public function tags()
	{
		return $this->hasManyThrough(\App\Tag::class, \App\ModelHasTag::class, 'model_id', 'id', 'id', 'tag_id')->where('model_type', __CLASS__);
	}

	public function lang()
	{
		return $this->hasOneThrough(\App\Language::class, \App\ModelHasLanguage::class, 'model_id', 'id', 'id', 'language_id')->where('model_type', __CLASS__);
	}

	public function tagsRelationship()
	{
		return $this->hasMany(\App\ModelHasTag::class, 'model_id')->where('model_type', __CLASS__);
	}

	public function langRelationship()
	{
		return $this->hasOne(\App\ModelHasLanguage::class, 'model_id')->where('model_type', __CLASS__);
	}

	public function publisher()
	{
		return $this->hasOne(\App\User::class, 'id', 'published_by');
	}

	public function scopeFiltered($query, $bible)
	{
		if (!request()->query('all-versions')) {
			$query->where('bible_version_id', $bible->id);
		}
		// if ( request()->query('language') ) {
		// $query->where('language_id', $bible->language->id);
		// }
		return $query;
	}
}

/*
	$articles = \App\Article::where(['book_index'=>$bible->book->index, 'chapter_index'=>$bible->book->chapter->index??null]);
	if ($strictVersion) {
			$articles = $articles = $articles=->where('bible_version_id', $bible->id);
	}
	if ($strictLang) {
			$articles = $articles = $articles=->where('language_id', $bible->language->id);
	}
*/

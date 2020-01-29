<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Traits\HasLanguage;
use App\Traits\HasTags;

class Article extends Model
{
	use HasLanguage;
	use HasTags;

	protected $fillable = ['bible_version_id', 'book_index', 'chapter_index', 'user_id', 'meta', 'title', 'slug', 'sample', 'content', 'published_by'];

	public function author()
	{
		return $this->hasOne(\App\User::class, 'id', 'user_id');
	}

	public function bible()
	{
		return $this->belongsTo(\App\BibleVersion::class, 'bible_version_id')
			->with(['book' => function($q) {
				return $q->with(['chapter' => function($query) {
					return $query->where('index', DB::raw('article.chapter_index'));
				}])->where('index', DB::raw('article.book_index'));
			}]);
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

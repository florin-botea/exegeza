<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Traits\HasLanguage;
use App\Traits\HasTags;
use Awobaz\Compoships\Compoships; // for multiple column relationship

class Article extends Model
{
	use HasLanguage;
	use HasTags;
	use Compoships;

	protected $fillable = [
		'bible_version_id', 
		'book_index',
		'book_id',
		'chapter_index',
		'chapter_id',
		'user_id',
		'cite_from',
		'meta',
		'title',
		'slug',
		'sample',
		'content',
		'published_by'
	];

	public function author()
	{
		return $this->hasOne(\App\User::class, 'id', 'user_id');
	}

	public function publisher()
	{
		return $this->hasOne(\App\User::class, 'id', 'published_by');
	}

	public function views()
	{
        return $this->hasMany(\App\ViewLog::class, 'article_id');
	}
	
	public function makeViewLog()
	{
        if (!$this->deleted_at && $this->published_by) {
            $this->views()->firstOrCreate([
                'article_id' => $this->id,
                'session_id' => \Request::getSession()->getId()
            ], [
                'slug' => $this->slug,
                'url' => \Request::url(),
                'user_id' => \Auth::id(),
                'ip_address' => \Request::getClientIp(),
                'user_agent' => \Request::header('User-Agent')
            ]);
        }
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

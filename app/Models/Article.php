<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasLanguage;
use App\Traits\HasTags;
use Awobaz\Compoships\Compoships; // for multiple column relationship
use Illuminate\Support\Facades\Auth;
use App\Traits\LogImages;
use Illuminate\Support\Facades\Request;

class Article extends Model
{
	use HasLanguage;
	use HasTags;
	use Compoships;
	use LogImages;

	protected $fillable = [
		'user_id',
		'cite_from',
		'bible_version_id',
		'book_index',
		'book_id',
		'chapter_index',
		'chapter_id',
		'meta',
		'title',
		'slug',
		'sample',
		'content',
		'published_by'
	];

	private $logImages = ['content'];

	/************************************ FORMATTERS ************************************/

	public function getCreatedAtAttribute($date)
	{
		return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d-m-Y');
	}

	public function getUpdatedAtAttribute($date)
	{
		return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d-m-Y');
	}

	/************************************ RELATIONSHIPS ************************************/

	public function author()
	{
		return $this->hasOne(User::class, 'id', 'user_id');
	}

	public function publisher()
	{
		return $this->hasOne(User::class, 'id', 'published_by');
	}

	public function bible()
	{
		return $this->hasOne(BibleVersion::class, 'id', 'bible_version_id');
	}

	public function book()
	{
		return $this->hasOne(Book::class, ['id', 'id'], ['book_id', 'bible_version_id']);
	}

	public function views()
	{
        return $this->hasMany(ViewLog::class, 'article_id');
	}

    public function comments()
    {
        return $this->hasMany(Comment::class)->where('model_type', get_class($this));
    }

	/************************************ ACTIONS ************************************/

	public function makeViewLog()
	{
        if (!$this->deleted_at && $this->published_by) {
            $this->views()->firstOrCreate([
                'article_id' => $this->id,
                'session_id' => Request::getSession()->getId()
            ], [
                'slug' => $this->slug,
                'url' => Request::url(),
                'user_id' => Auth::id(),
                'ip_address' => Request::getClientIp(),
                'user_agent' => Request::header('User-Agent')
            ]);
        }
	}

	/************************************ GETTERS ************************************/

	public function getBible()
	{
        return BibleVersion::fetch([
            'bible' => ['id' => $this->bible_version_id],
            'book' => ['id' => $this->book_id],
            'chapter' => ['id' => $this->chapter_id]
        ]);
	}

	public function getRelated()
	{
		$tag_ids = $this->tags->pluck('id');
		return self::whereHas('tags', function($query) use ($tag_ids){
			$query->whereIn('tags.id', $tag_ids);
		})->whereNotNull('published_by')->whereNotIn('id', [$this->id])->get();
	}

	/************************************ FILTERS ************************************/

	public function scopeFiltered($query, $args = [])
	{
		extract($args);

		$published = (Auth::check() && Auth::user()->can('publish articles')) ? ($public ?? 'true') : 'true';

		//$target = [];
		//isset($book_id) ? $target['book_id'] = $book_id : false;
		//isset($chapter) ? $target['chapter_index'] = $chapter : false;
		//if (count($target > 0)) $query = $query->where($target);
		if(isset($cite) && count($cite) > 0) {
			$query = $query->where('cite_from', 'LIKE', $keyword.'%');
		}

		$published == 'true' ? $query->whereNotNull('published_by') : $query->whereNull('published_by');

		if (isset($keyword)) {
			$query = $query->where(function($q) use ($keyword) {
				$q->where('title', 'LIKE', '%'.$keyword.'%')
					->orWhere('content', 'LIKE', '%'.$keyword.'%')
					->orWhereHas('tags', function($tag) use ($keyword) { $tag->where('value', 'LIKE', '%'.$keyword.'%'); });
			});
		}
		if (isset($language) && $language != 'default') {
			$query = $query->whereHas('language', function($q) use ($language) {
				$q->where('value', $language);
			});
		}
		if (isset($author)) {
			$query = $query->whereHas('author', function($q) use ($author) {
				$q->where('name', 'LIKE', '%'.$author.'%');
			});
		}
		switch($sort ?? 'date-desc') {
			case 'date-asc': $query = $query->orderBy('updated_at');
			break;
			case 'date-desc': $query = $query->orderBy('updated_at', 'desc');
			break;
		}

		return $query;
	}
}


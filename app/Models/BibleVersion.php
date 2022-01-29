<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use App\Traits\HasLanguage;
use Awobaz\Compoships\Compoships; // for multiple column relationship

class BibleVersion extends Model
{
	use SoftDeletes;
	use HasLanguage;
	use Compoships;

	protected $fillable = ['index', 'name', 'alias', 'slug', 'public'];

	public function books()
	{
		return $this->hasMany(Book::class);
	}

	public function book()
	{
		return $this->hasOne(Book::class);
	}

	public function verses()
	{
		return $this->hasMany(Verse::class);
	}

	public static function fetch(array $args)
	{
		$canManageBibles = Auth::user() && Auth::user()->can('manage bibles');
		$bible = null;
		if (empty($args)) return $bible;

		$bible_where = $args['bible'] ?? []; //Arr::only($args, ['bible_version_id', 'bible_version_index', 'bible_version_slug']);
		$book_where = $args['book'] ?? []; //Arr::only($args, ['book_id', 'book_index', 'book_slug']);
		$chapter_where = $args['chapter'] ?? []; //Arr::only($args, ['chapter_id', 'chapter_index', 'chapter_slug']);
		$eager = !empty($bible_where) ? 'bible_books' : null;
		$eager = !empty($book_where) ? 'bible_book_chapters' : $eager;
		$eager = !empty($chapter_where) ? 'bible_book_chapter' : $eager;
		if (!$canManageBibles) $bible_where['public'] = 1;

		switch ($eager) {
			case 'bible_books':
				$bible = BibleVersion::with('books', 'language')->where($bible_where)->firstOrFail();
				$books = $bible->books->groupBy('type');
				unset($bible->books);
				$bible->setAttribute('book', null);
				$bible->setAttribute('books', $books);
			break;
			case 'bible_book_chapters':
				$bible = BibleVersion::with('language')->with([ 'book' => function ($query) use ($book_where) {
					return $query->where($book_where);
				}])->where($bible_where)->firstOrFail();
				$bible->book->setAttribute('chapter', null);
			break;
			case 'bible_book_chapter':
				$bible = BibleVersion::with('language')->with([ 'book' => function ($query) use ($book_where, $chapter_where) {
					return $query->with(['chapter' => function($query) use ($chapter_where) {
						return $query->where($chapter_where);
					}])->where($book_where);
				}])->where($bible_where)->firstOrFail();
			break;
		}

		return $bible;
	}

	public function toFlatArray()
	{
		$arr = ['bible' => $this->name];

		if ($this->book) $arr['book'] = $this->book->name;
		if ($this->book && $this->book->chapter) $arr['chapter'] = $this->book->chapter->index;

		return $arr;
	}

	public function chapterIndex ()
	{
		return ($this->relationLoaded('book') && $this->book && $this->book->relationLoaded('chapter') && $this->book->chapter) ? $this->book->chapter->index : null;
	}
}

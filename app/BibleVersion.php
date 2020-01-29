<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class BibleVersion extends Model
{
	use SoftDeletes;

	protected $fillable = ['index', 'name', 'alias', 'slug', 'public'];

	public function books()
	{
		return $this->hasMany(\App\Book::class);
	}

	public function book()
	{
		return $this->hasOne(\App\Book::class);
	}

	public function language()
	{
		return $this->hasOneThrough(\App\Language::class, \App\ModelHasLanguage::class, 'model_id', 'id')
			->where('model_type', __CLASS__);
	}

	public static function fetch(array $args)
	{
		if (empty($args)) {
			return null;
		}
		extract($args);

		if ($book_id ?? false) {
			$whereClause = ['id' => $book_id];
		} elseif ($book_index ?? false) {
			$whereClause = ['index' => $book_index];
		} elseif ($book_slug ?? false) {
			$whereClause = ['slug' => $book_slug];
		} else {
			return null;
		}

        $bible = self::with(['book' => function ($query) use ($whereClause) {
			return $query->where($whereClause)->with('chapters');
		}]);

		if ($bible_version_id ?? false) {
			$whereClause = ['id' => $bible_version_id];
		} elseif ($bible_version_index ?? false) {
			$whereClause = ['index' => $bible_version_index];
		} elseif ($bible_version_slug ?? false) {
			$whereClause = ['slug' => $bible_version_slug];
		} else {
			return null;
		}

		$bible = $bible = $bible->where($whereClause)->firstOrFail();
		
		if ($chapter_id ?? false) {
			$chapter_id = $chapter_id;
		} elseif ($chapter_index ?? false) {
			$chapter_id = $bible->book->chapter()->where('index', $chapter_index)->firstOrFail()->id;
		} else {
			$bible->book->setAttribute('chapter', null);
			return $bible;
		}

		$table_name = 'v_' . $bible->id . '_verses';
		if (Schema::hasTable($table_name)) {
			$verses = DB::table($table_name)->where(['book_id' => $bible->book->id, 'chapter_id' => $bible->book->chapter->id])->orderBy('index')->get();
			$bible->book->chapter->setAttribute('verses', $verses);
			return $bible;
		} else {
			return null;
		}
	}
}

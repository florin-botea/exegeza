<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Chapter extends Model
{
	use SoftDeletes;

	protected $fillable = ['book_index', 'index', 'name'];

	public function book()
	{
		return $this->belongsTo(Book::class);
	}

	public function verses()
	{
		return $this->hasMany(Verse::class);
	}

	public function addVerses(array $verses)
	{
		$stack = [];
		for ($i = 0; $i < count($verses); $i++) {
			$stack[] = [
				'bible_version_id' => $this->book->bible_version_id,
				'book_id' => $this->book->id,
				'chapter_id' => $this->id,
				'book_index' => $this->book->index,
				'chapter_index' => $this->index,
				'index' => $i + 1,
				'text' => $verses[$i]
			];
		}
		$this->verses()->delete();
		$this->verses()->insert($stack);
	}
}

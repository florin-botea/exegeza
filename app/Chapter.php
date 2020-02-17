<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Chapter extends Model
{
	use SoftDeletes;

	protected $fillable = ['index', 'name'];

	public function book()
	{
		return $this->belongsTo(\App\Book::class);
	}

	public function addVerses(array $verses)
	{
		$table_name = $this->book->bible->setVersesTable();

		$stack = [];
		for ($i = 0; $i < count($verses); $i++) {
			$stack[] = [
				'book_id' => $this->book->id,
				'book_index' => $this->book->index,
				'chapter_id' => $this->id,
				'chapter_id' => $this->index,
				'index' => $i + 1,
				'text' => $verses[$i]
			];
		}
		DB::table($table_name)->where(['book_id' => $this->book->id, 'chapter_id' => $this->book->chapter->id])->delete();
		DB::table($table_name)->insert($stack);
	}
}

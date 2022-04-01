<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Chapter extends Model
{
	use SoftDeletes;

	protected $fillable = ['book_index', 'index', 'name'];

    protected $appends = ['url'];

	public function book()
	{
		return $this->belongsTo(Book::class, 'book_index', 'index');
	}

	public function verses()
	{
		return $this->hasMany(Verse::class, 'chapter_index', 'index')
		->where('book_index', $this->book_index);
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
	
	// GETTERS
	public function getUrlAttribute()
	{
	    return route('chapter', [$this->book->slug, $this->index]);
	}
	
	public function getPrevAttribute()
	{
	    if ($this->index == 1 && $this->book_index == 1) {
	        return null;
	    }
	    
	    $book_index = $this->book_index;
	    $chapter_index = $this->index;
	    if ($this->index == 1) {
	        $book_index--;
	    } else {
	        $chapter_index--;
	    }
	        
	    return Chapter::where('book_index', $book_index)
	    ->where('index', $chapter_index)
	    ->first();
	}
	
	public function getNextAttribute()
	{
	    $last = $this->book->chapters->last();
	    
	    $book_index = $this->book_index;
	    $chapter_index = $this->index;
	    if ($this->index == $last->index) {
	        $book_index++;
	        $chapter_index = 1;
	    } else {
	        $chapter_index++;
	    }
	        
	    return Chapter::where('book_index', $book_index)
	    ->where('index', $chapter_index)
	    ->first();
	}
}

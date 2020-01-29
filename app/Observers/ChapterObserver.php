<?php

namespace App\Observers;

use App\Chapter;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ChapterObserver
{
    /**
     * Handle the chapter "created" event.
     *
     * @param  \App\Chapter  $chapter
     * @return void
     */
    /*public function created(Chapter $chapter)
    {
				if (!request()->add_verses || $chapter->index < 0) {
						return;
				}
        $this->addVerses(request(), $chapter);
    }*/

    /**
     * Handle the chapter "updated" event.
     *
     * @param  \App\Chapter  $chapter
     * @return void
     *//*
    public function updated(Chapter $chapter)
    {
				if (!request()->add_verses || $chapter->index < 0) {
						return;
				}
        $this->addVerses(request(), $chapter);
    }*/

    /**
     * Handle the chapter "deleted" event.
     *
     * @param  \App\Chapter  $chapter
     * @return void
     */
    public function deleted(Chapter $chapter)
    {
        //
    }

    /**
     * Handle the chapter "restored" event.
     *
     * @param  \App\Chapter  $chapter
     * @return void
     */
    public function restored(Chapter $chapter)
    {
        //
    }

    /**
     * Handle the chapter "force deleted" event.
     *
     * @param  \App\Chapter  $chapter
     * @return void
     */
    public function forceDeleted(Chapter $chapter)
    {
        //
    }
		
		private function addVerses ($request, $chapter)
		{	/*
				$bible = $request->bible_version;
				$book = $request->book;
				
				$bible = \App\BibleVersion::with(['book' => function($query) use ($book, $chapter) {
						return $query->with(['chapter' => function($query) use ($chapter) {
								return $query->where('id', $chapter->id)->first();
						}])->where('id', $book)->first();
				}])->where('id', $bible)->firstOrFail();
				
				$table_name = 'v_' . $bible->id . '_verses';
				$verses = preg_split($request->regex, $request->verses);
				
				$stack = [];
				for ($i=0;$i<count($verses);$i++){
						$stack[] = [
								'book_id' => $bible->book->id,
								'chapter_id' => $bible->book->chapter->id,
								'index' => $i + 1,
								'text' => $verses[$i]
						];
				}
				DB::table($table_name)->where(['book_id' => $bible->book->id, 'chapter_id' => $bible->book->chapter->id])->delete();
				DB::table($table_name)->insert($stack);*/
		}
}

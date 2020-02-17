<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BibleSearchController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
		if (!$request->words || $request->words == '' || !$request->words === null || strlen($request->words) < 3 ){
			return back();
		}
		$bible = \App\BibleVersion::where('slug', $request->translation)->firstOrFail();
		$table_name = 'v_'.$bible->id.'_verses';
		
		$words = explode(' ', $request->words);
		if ( $request->flexibility === 'relative' ){
			$words = array_map( function($word){
				return strlen($word) > 5 ? substr($word, 1, -2) : $word;
			}, $words);
		}
		
		$query = DB::table($table_name);
		
		if ( $request->eager === 'all' ){//sa le contina pe toate
			foreach( $words as $word ){
				$query->where('text', 'like', '%'.$word.'%');
			}
		}
		elseif ( $request->eager === 'expression' ){
			$words = implode(' ', $words);
			$query->where($table_name.'.text', 'like', '%'.$word.'%');
		}
		else { //flexible
			foreach( $words as $i => $word ){
				$i === 0 ? $query->where($table_name.'.text', 'like', '%'.$word.'%') : $query->orWhere($table_name.'.text', 'like', '%'.$word.'%');
			}
		}
		//if ( $request->book !== 'all' ){
		//	$book = \App\Book::where(['bible_version_id' => $bible->id, 'slug' => $request->book])->firstOrFail();
		//	$query->where($table_name.'.book_id', $book->id);
		//}
		//$query->join('books', $table_name.'.book_id', '=', 'books.id');
		//$query->join('chapters', $table_name.'.chapter_id', '=', 'chapters.id')
		//	->select(['books.name as book_name', 'books.index as book_index', 'chapters.index as chapter_index', $table_name.'.index', $table_name.'.text']);

        $searchResults = $query->paginate(50)->withPath(request()->fullUrl());
        
        $this->inspect($searchResults);

		//return view('search')->with(['searchResults' => $searchResults]);
    }
}

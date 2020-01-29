<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ValidBook;

class BooksController extends Controller
{
	public function __construct()
	{
		$this->middleware('slugify', ['only' => ['store', 'update']]);
	}

	public function index($bibleVersion)
	{
		abort(404);
	}

	public function show(string $bible_slug, string $book_slug)
	{
		$bible = \App\BibleVersion::fetch([
			'bible_version_slug' => $bible_slug,
			'book_slug' => $book_slug,
		]);
		$articles = \App\Article::where([
			'book_index'=>$bible->book->index, 
			'chapter_index'=>null
		])->whereNotNull('published_by')
		->filtered($bible)->get();
	
		return view('chapter')->with(compact('bible', 'articles'));
	}

	public function create($bibleVersion)
	{
		$bibleBooks = \App\BibleVersion::with('books')->where('slug', $bibleVersion)->first();

		return view('manage-books')->with('bible', $bibleBooks);
	}

	public function store(ValidBook $request, int $bibleVersion)
	{
		\App\BibleVersion::findOrFail($bibleVersion)->books()->create($request->all());

		return back();
	}

	public function update(ValidBook $request, int $bibleVersion, int $id)
	{
		\App\Book::findOrFail($id)->update($request->all());

		return back();
	}

	public function destroy(int $bibleVersion, int $id)
	{
		$book = \App\Book::find($id);
		$book->index = -1;
		$book->alias = 'del-' . $book->alias;
		$book->save();
		\App\Book::where('id', $id)->delete();

		return back();
	}
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ValidBook;
use App\Article;

class BooksController extends Controller
{
	public function __construct()
	{
		//$this->middleware('slugify', ['only' => ['store', 'update']]);
	}

	public function index($bibleVersion)
	{
		abort(404);
	}

	public function show(Request $request, string $bible_slug, string $book_slug)
	{
		$bibles = \App\BibleVersion::all();
		
		$bible = \App\BibleVersion::fetch([
			'bible_version_slug' => $bible_slug,
			'book_slug' => $book_slug,
		]);

		$articles = Article::filtered($request->all())->paginate(1)->appends($request->query());
		$last_articles = Article::whereNotNull('published_by')->where('bible_version_id', $bible->id)->orderBy('created_at', 'desc')->limit(10)->get();
		$popular_articles = Article::withCount('views')->whereNotNull('published_by')->orderBy('views_count', 'desc')->limit(10)->get();
	
		return view('chapter')->with(compact('bible', 'bibles', 'articles', 'last_articles', 'popular_articles'));
	}

	public function create($bibleVersion)
	{
		abort(404);
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

	public function manage($bible_id)
	{
		$bible = \App\BibleVersion::with('books')->findOrFail($bible_id);

		return view('dev.books')->with(compact('bible'));
	}
}

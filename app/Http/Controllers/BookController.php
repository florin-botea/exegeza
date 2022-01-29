<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ValidBook;
use App\Article;

class BookController extends Controller
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
		$bible = BibleVersion::fetch([
			'bible' => ['slug' => $bible_slug],
			'book' => ['slug' => $book_slug],
		]);

		if (strlen ($request->query('search-word', '')) > 1) {
			$verses = $bible->book->verses()->with('book', 'bible')
				->where('text', 'LIKE', '%'.$request->query('search-word').'%')->paginate(100)->appends($request->all());

			return view('bible@search')->with(compact('verses','bible'));
		}

		$articles = Article::filtered(array_merge($request->all(), [
			'book_id' => $bible->book->id
		]))->paginate(10)->appends($request->query());

		return view('bible@chapter(s)')->with(compact('bible', 'articles'));
	}

	public function create($bibleVersion)
	{
		abort(404);
	}

	public function store(ValidBook $request, int $bibleVersion)
	{
		BibleVersion::findOrFail($bibleVersion)->books()->create($request->all());

		return back();
	}

	public function update(ValidBook $request, int $bibleVersion, int $id)
	{
		Book::findOrFail($id)->update($request->all());

		return back();
	}

	public function destroy(int $bibleVersion, int $id)
	{
		$book = Book::find($id);
		$book->index = -1;
		$book->alias = 'del-' . $book->alias;
		$book->save();
		Book::where('id', $id)->delete();

		return back();
	}

	public function manage($bible_id)
	{
		$bible = BibleVersion::with('books')->findOrFail($bible_id);

		return view('dev.books')->with(compact('bible'));
	}
}

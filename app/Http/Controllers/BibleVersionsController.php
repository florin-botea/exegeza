<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ValidBibleVersion;

class BibleVersionsController extends Controller
{
	public function __construct()
	{
		$this->middleware('slugify', ['only' => ['store', 'update']]);
	}

	public function index()
	{
		abort(404);
	}

	public function create()
	{
		abort(404);
	}

	public function show(string $bible_slug)
	{
		$bible = \App\BibleVersion::with('books', 'language')->where('slug', $bible_slug)->first();
		$books = $bible->books->groupBy('type');
		unset($bible->books);
		$bible->setAttribute('books', $books);
		$articles = \App\Article::withCount('views')
		->join('books', function($join) {
			return $join->on('articles.bible_version_id', '=', 'books.bible_version_id')
				->on('articles.book_index', '=', 'books.index');
		})
		->where('articles.bible_version_id', $bible->id)->get();
		$this->inspect($articles);

		return view('books')->with(compact('bible'));
	}

	public function store(ValidBibleVersion $request)
	{
		$bible = \App\BibleVersion::create($request->all());
		$bible->setLanguage($request->input('language'));
		$bible->setVersesTable();

		return back();
	}

	public function update(ValidBibleVersion $request, $id)
	{
		\App\BibleVersion::findOrFail($id)->update($request->all());
		$bible = \App\BibleVersion::findOrFail($id);
		\App\BibleVersion::findOrFail($id)->setVersesTable();

		return redirect( route('bible-versions.show', $bible->slug) );
	}

	public function destroy($id)
	{
		\App\BibleVersion::where('id', $id)->delete();

		return redirect("/");
	}
}

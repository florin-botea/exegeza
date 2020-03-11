<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ValidBibleVersion;
use App\BibleVersion;

class BibleVersionsController extends Controller
{
	public function __construct()
	{
		//$this->middleware('slugify', ['only' => ['store', 'update']]);
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
		$bibles = \App\BibleVersion::all();
		$bible = \App\BibleVersion::with('books', 'language')->where('slug', $bible_slug)->first();
		$books = $bible->books->groupBy('type');
		unset($bible->books);
		$bible->setAttribute('books', $books);
		$last_articles = \App\Article::whereNotNull('published_by')->where('bible_version_id', $bible->id)->orderBy('created_at', 'desc')->limit(10)->get();
		$popular_articles = \App\Article::withCount('views')->whereNotNull('published_by')->orderBy('views_count', 'desc')->limit(10)->get();

		return view('books')->with(compact('bible', 'bibles', 'last_articles', 'popular_articles'));
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

		return back();
	}

	public function destroy($id)
	{
		\App\BibleVersion::where('id', $id)->delete();

		return back();
	}

	public function manage()
	{
		$bibles = BibleVersion::all();

		return view('dev.bible-versions')->with(compact('bibles'));
	}
}

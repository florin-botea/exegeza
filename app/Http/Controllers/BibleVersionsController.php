<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ValidBibleVersion;
use App\BibleVersion;
use App\Article;

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

	public function show(Request $request, string $bible_slug)
	{
		$bible = \App\BibleVersion::fetch([
			'bible' => ['slug' => $bible_slug]
		]);

		if (strlen ($request->query('search-word', '')) > 1) {
			$verses = $bible->verses()->with('book', 'bible')
				->where('text', 'LIKE', '%'.$request->query('search-word').'%')->paginate(100)->appends($request->all());

			return view('bible@search')->with(compact('verses','bible'));
		}

		$articles = Article::filtered($request->all())->where('bible_version_id', $bible->id)->paginate(10)->appends($request->query());

		return view('bible@books')->with(compact('bible', 'articles'));
	}

	public function store(ValidBibleVersion $request)
	{
		$bible = \App\BibleVersion::create($request->all());
		$bible->setLanguage($request->input('language'));

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

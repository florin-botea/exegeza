<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\BibleVersion as ValidBibleVersion;

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
		$bibleVersions = \App\BibleVersion::with('language')->get();

		return view('manage-bible-versions')->with('bibleVersions', $bibleVersions);
	}

	public function show(string $bible_slug)
	{
		$bible = \App\BibleVersion::with('books')->where('slug', $bible_slug)->first();
		$books = $bible->books->groupBy('type');
		unset($bible->books);
		$bible->setAttribute('books', $books);

		return view('books')->with(compact('bible'));
	}

	public function store(ValidBibleVersion $request)
	{
		$bible = \App\BibleVersion::create($request->all());

		return back();
	}

	public function update(ValidBibleVersion $request, $id)
	{
		\App\BibleVersion::findOrFail($id)->update($request->all());
		\App\BibleVersion::findOrFail($id)->touch();

		return back();
	}

	public function destroy($id)
	{
		$bibleVersion = \App\BibleVersion::find($id);
		$bibleVersion->index = -1;
		$bibleVersion->alias = 'del-' . $bibleVersion->alias;
		$bibleVersion->save();
		\App\BibleVersion::where('id', $id)->delete();

		return back();
	}
}

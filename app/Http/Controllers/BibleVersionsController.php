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
		abort(404);
	}

	public function show(string $bible_slug)
	{
		$bible = \App\BibleVersion::with('books', 'language')->where('slug', $bible_slug)->first();
		$books = $bible->books->groupBy('type');
		unset($bible->books);
		$bible->setAttribute('books', $books);

		return view('books')->with(compact('bible'));
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
		\App\BibleVersion::findOrFail($id)->touch();

		return redirect( route('bible-versions.show', $bible->slug) );
	}

	public function destroy($id)
	{
		\App\BibleVersion::where('id', $id)->delete();

		return redirect("/");
	}
}

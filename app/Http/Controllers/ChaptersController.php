<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Chapter as ValidChapter;
use Illuminate\Database\Schema\Blueprint;

class ChaptersController extends Controller
{
	public function __construct()
	{
	}

	public function index(Request $request, string $bibleVersion, string $book)
	{
		abort(404);
	}

	public function show(string $bible_slug, string $book_slug, int $chapter_index)
	{
		if ($chapter_index < 1) abort(404);
		$bible = \App\BibleVersion::fetch([
			'bible_version_slug' => $bible_slug,
			'book_slug' => $book_slug,
			'chapter_index' => $chapter_index
		]);
		$articles = \App\Article::where([
			'book_index'=>$bible->book->index, 
			'chapter_index'=>$bible->book->chapter->index
		])->whereNotNull('published_by')
		->filtered($bible)->get();

		return view('chapter')->with(compact('bible', 'articles'));
	}

	public function create(string $bibleVersion, string $book)
	{
		$bible = \App\BibleVersion::with(['book' => function ($query) use ($book) {
			return $query->where('slug', $book)->with('chapters');
		}])->where('slug', $bibleVersion)->firstOrFail();

		return view('manage-chapters')->with('bible', $bible);
	}

	public function store(ValidChapter $request, int $bibleVersion, int $book)
	{
		$bible = \App\BibleVersion::with(['book' => function ($query) use ($book) {
			return $query->where('id', $book);
		}])->findOrFail($bibleVersion);
		$bible->book->chapters()->create($request->all());

		return back(); //return back in add_verses after middleware
	}

	public function update(ValidChapter $request, int $bibleVersion, int $book, int $id)
	{
		\App\Chapter::findOrFail($id)->update($request->all());
		\App\Chapter::findOrFail($id)->touch();

		return back(); //return back add_verses in after middleware
	}

	public function destroy(int $bible, int $book, int $id)
	{
		$chapter = \App\Chapter::findOrFail($id);
		$chapter->index = -1;
		$chapter->save();
		\App\Chapter::where('id', $id)->delete();

		return back();
	}
}

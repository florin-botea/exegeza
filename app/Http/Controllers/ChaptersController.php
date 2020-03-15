<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ValidChapter;
use App\Article;

class ChaptersController extends Controller
{
	public function __construct()
	{
	}

	public function index(Request $request, string $bibleVersion, string $book)
	{
		abort(404);
	}

	public function show(Request $request, string $bible_slug, string $book_slug, int $chapter_index)
	{
		if ($chapter_index < 1) abort(404);

		$bibles = \App\BibleVersion::all();
		$bible = \App\BibleVersion::fetch([
			'bible_version_slug' => $bible_slug,
			'book_slug' => $book_slug,
			'chapter_index' => $chapter_index
		]);

		$articles = Article::filtered($request->all())->paginate(1)->appends($request->query());
		$last_articles = Article::whereNotNull('published_by')->where('bible_version_id', $bible->id)->orderBy('created_at', 'desc')->limit(10)->get();
		$popular_articles = Article::withCount('views')->whereNotNull('published_by')->orderBy('views_count', 'desc')->limit(10)->get();
	
		return view('chapter')->with(compact('bible', 'bibles', 'articles', 'last_articles', 'popular_articles'));
	}

	public function create(string $bibleVersion, string $book)
	{
		abort(404);
	}

	public function store(ValidChapter $request, int $bibleVersion, int $book)
	{
		$bible = \App\BibleVersion::with(['book' => function ($query) use ($book) {
			return $query->where('id', $book);
		}])->findOrFail($bibleVersion);
		$chapter = $bible->book->chapters()->create($request->all());
		if ($request->input('add_verses')) {
			$verses = preg_split($request->regex, $request->verses);
			$chapter->addVerses($verses);
		}

		return back(); //return back in add_verses after middleware
	}

	public function update(ValidChapter $request, int $bibleVersion, int $book, int $id)
	{
		\App\Chapter::findOrFail($id)->update($request->all());
		if ($request->input('add_verses')) {
			$verses = preg_split($request->regex, $request->verses);
			\App\Chapter::findOrFail($id)->addVerses($verses);
		}

		return back(); //return back add_verses in after middleware
	}

	public function destroy(int $bible, int $book, int $id)
	{
		\App\Chapter::where('id', $id)->delete();
		$bible = \App\BibleVersion::findOrFail($bible);
		$book = \App\Book::findOrFail($book);

		return redirect( route('bible-versions.books.show', [$bible->slug, $book->slug]));
	}

	public function manage(int $bible, int $book)
	{
		$bible = \App\BibleVersion::fetch([
			'bible_version_id' => $bible,
			'book_id' => $book,
		]);

		return view('dev.chapters')->with(compact('bible'));
	}
}

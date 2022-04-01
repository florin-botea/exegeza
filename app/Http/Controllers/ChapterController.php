<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ValidChapter;
use App\Article;
use App\Models\Book;
use PhpTemplates\Facades\Template;

class ChapterController extends Controller
{
	public function __construct()
	{
	}

	public function index(Request $request, string $bibleVersion, string $book)
	{
		abort(404);
	}

	public function show(Request $request, string $book_slug, int $chapter_index)
	{
		$book = Book::where('slug', $book_slug)->with('chapters.book')->firstOrFail();
        $chapters = $book->chapters;
        $chapter = $chapters->where('index', $chapter_index)->firstOrFail();
        $verses = $chapter->verses;
        $breadcrumbs[] = [
            'name' => 'Home',
            'href' => '/'
        ];
        $breadcrumbs[] = [
            'name' => $book->name,
            'href' => $book->url
        ];
        $breadcrumbs[] = [
            'name' => $chapter->name
        ];
        
        $prev = $next = null;
        if ($prev = $chapter->prev) {
            $prev = [
                'href' => $prev->url,
                'name' => $prev->book_index != $chapter->book_index ? $prev->book->name : $prev->name
            ];
        }
        if ($next = $chapter->next) {
            $next = [
                'href' => $next->url,
                'name' => $next->book_index != $chapter->book_index ? $next->book->name : $next->name
            ];
        }
        
        Template::load('chapter@show', compact('book', 'chapters', 'chapter', 'verses', 'breadcrumbs', 'prev', 'next'));
	return;
	
	
	
		if ($chapter_index < 1) abort(404);

		$bible = BibleVersion::fetch([
			'bible' => ['slug' => $bible_slug],
			'book' => ['slug' => $book_slug],
			'chapter' => ['index' => $chapter_index]
		]);

		$articles = Article::filtered($request->all())->paginate(10)->appends($request->query());

		return view('bible@chapter(s)')->with(compact('bible', 'articles'));
	}

	public function create(string $bibleVersion, string $book)
	{
		abort(404);
	}

	public function store(ValidChapter $request, int $bibleVersion, int $book)
	{
		$bible = BibleVersion::with(['book' => function ($query) use ($book) {
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
		Chapter::findOrFail($id)->update($request->all());
		if ($request->input('add_verses')) {
			$verses = preg_split($request->regex, $request->verses);
			Chapter::findOrFail($id)->addVerses($verses);
		}

		return back(); //return back add_verses in after middleware
	}

	public function destroy(int $bible, int $book, int $id)
	{
		Chapter::where('id', $id)->delete();

		return back();
	}

	public function manage(int $bible, int $book)
	{
		$bible = BibleVersion::fetch([
			'bible' => ['id' => $bible],
			'book' => ['id' => $book],
		]);

		return view('dev.chapters')->with(compact('bible'));
	}
}

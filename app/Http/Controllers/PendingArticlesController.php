<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PendingArticle as ValidPendingArticle;
use \App\Article;

class PendingArticlesController extends Controller
{
    public function __construct(Request $request)
    {
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::with('author', 'bible.book')->where('published_by', null)->get();

        return view('pending-articles')->with(compact('articles'));
    }

    /**
     * Accepta qs cu parametrii bible-id, book-index, chapter-index
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, string $version_slug, string $book_slug, int $chapter_index = 0)
    {
        $bible = \App\BibleVersion::fetch([
            'bible_version_slug' => $version_slug,
            'book_slug' => $book_slug,
            'chapter_index' => $chapter_index
        ]) ?? abort(404);

        return view('article-pending-form')->with(compact('bible'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValidPendingArticle $request)
    {
        $data = $request->all();
        $data['user_id'] = 1;
        $article = Article::create($data);
        //redirect user posts
        return redirect(route('pending-articles.show', $article->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Article::find($id);
        $bible = \App\BibleVersion::fetch([
            'bible_version_id' => $article->bible_version_id,
            'book_index' => $article->book_index,
            'chapter_index' => $article->chapter_index
        ]);

        return view('article')->with(compact('article', 'bible'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $article = Article::with('tags')->find($id);
        $bible = \App\BibleVersion::fetch([
            'bible_version_id' => $article->bible_version_id,
            'book_index' => $article->book_index,
            'chapter_index' => $article->chapter_index
        ]);

        return view('article-pending-form')->with(compact('bible', 'article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Article::findOrFail($id)->update([
            'title' => $request->title,
            'content' => $request->content,
            'public' => false
        ]);
        $article = Article::findOrFail($id);
        
        return redirect( route('pending-articles.show', $article->id) );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

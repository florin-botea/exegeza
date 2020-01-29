<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PublishArticle as ValidArticle;
use Illuminate\Support\Facades\Input;
use App\Article;

class ArticlesController extends Controller
{
	public function __construct()
	{
		$this->middleware('slugify', ['only' => ['update']]);
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort(404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();
		$bible = \App\BibleVersion::fetch([
            'bible_version_id' => $article->bible_version_id,
            'book_index' => $article->book_index,
            'chapter_index' => $article->chapter_index
        ]);

        return view('article')->with(compact('article', 'bible'));
    }

    /**
     * Show the form for publishing target pending article
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = Article::with('tags', 'lang')->findOrFail($id);
        if ($article->public) { //nu are un h1 in start
            $article->content = "<h1>$article->title</h1>".$article->content;
        }
		$bible = \App\BibleVersion::fetch([
            'bible_version_id' => $article->bible_version_id,
            'book_index' => $article->book_index,
            'chapter_index' => $article->chapter_index
        ]);

        return view('article-publish-form')->with(compact('article', 'bible'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ValidArticle $request, $id)
    {
        $content = preg_replace ('/^<h1>.*<\/h1>/', '', $request->content, 1);
        Article::findOrFail($id)->update([
            'meta' => $request->meta,
            'title' => $request->title,
            'slug' => $request->slug,
            'sample' => $request->sample,
            'content' => $content,
            'published_by' => 1
        ]);

        return redirect( route('articles.show', $request->slug) );
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

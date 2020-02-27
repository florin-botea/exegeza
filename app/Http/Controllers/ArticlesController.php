<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ValidArticle;
use Illuminate\Support\Facades\Input;
use App\Article;

class ArticlesController extends Controller
{
	public function __construct()
	{
		$this->middleware('slugify', ['only' => ['store', 'update', 'publish']]);
	}

    public function index(Request $req)
    {

        // set it xmlhttp
    }

    public function create(Request $request)
    {
        $bible = \App\BibleVersion::fetch([
            'bible_version_slug' => $request->query('bible-version'),
            'book_slug' => $request->query('book'),
            'chapter_index' => $request->query('chapter')
        ]) ?? abort(404, 'Bible resource not found, or has been deleted');

        return view('article-form')->with(compact('bible'));
    }

    public function store(ValidArticle $request)
    {
        $article = Article::create($request->all());
        $article->setLanguage($request->input('language'));
        $article->addTags(json_decode($request->tags, true));

        return redirect( route('articles.show', ['article'=>$article->slug, 'user'=>$article->user_id]) );
    }

    public function show($slug)
    {
        $article = Article::with('tags', 'language', 'author')->where('slug', $slug)->firstOrFail();
        $bible = $article->getBible();
        $popular_articles = null;
        if ($article->published_by) {
            $article->related = $article->getRelated();
            $popular_articles = \App\Article::withCount('views')->whereNotNull('published_by')->orderBy('views_count', 'desc')->limit(10)->get();
            $article->makeViewLog();
        }

        return view('article')->with(compact('article', 'bible', 'popular_articles'));
    }

    public function edit($id)
    {
        $article = Article::with('tags', 'language')->findOrFail($id);
		$bible = $article->getBible();

        return view('article-form')->with(compact('article', 'bible'));
    }

    public function update(ValidArticle $request, $id)
    {
        $article = Article::updateOrCreate(['id'=>$id], $request->all());
        $article->setLanguage($request->input('language'));
        $article->addTags(json_decode($request->tags, true));

        return redirect( route('articles.show', $article->slug) );
    }

    public function destroy($id)
    {
        //
    }

    public function publish(ValidArticle $request, int $id = 0)
    {
        if ($id > 0) {
            $article = Article::updateOrCreate(['id'=>$id], $request->all());
        } else {
            $article = \App\Article::create($request->all());
        }
        $article->setLanguage($request->input('language'));
        $article->addTags(json_decode($request->tags, true));

        return redirect( route('articles.show', $article->slug) );
    }
}

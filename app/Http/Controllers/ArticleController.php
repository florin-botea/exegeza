<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ValidArticle;
use Illuminate\Support\Facades\Input;
use App\Models\BibleVersion;
use App\Models\Article;

class ArticleController extends Controller
{
	public function __construct(Request $request)
	{
        //$this->middleware('slugify', ['only' => ['store', 'update', 'publish']]);
        //$this->middleware('can:create,\App\Article');
	}

    public function index(Request $request)
    {
        $articles = Article::filtered($request->all())->with('author', 'bible', 'book')->paginate(10)->appends($request->query());

        return view('articles')->with(compact('articles'));
    }

    public function create(Request $request)
    {
        //04, 'Bible resource not found, or has been deleted');
        $bible = null;
        return view('article/form')->with(compact('bible'));
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
        $article->related = $article->getRelated();
        if ($article->published_by) $article->makeViewLog();

        return view('article')->with(compact('article', 'bible'));
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
            $article = Article::create($request->all());
        }
        $article->setLanguage($request->input('language'));
        $article->addTags(json_decode($request->tags, true));

        return redirect( route('articles.show', $article->slug) );
    }
}

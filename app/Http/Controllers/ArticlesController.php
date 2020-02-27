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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $query = \App\Article::with('author')->where(['book_index' => $req->query('book'), 'chapter_index' => $req->query('chapter')])->whereNotNull('published_by');
        if ($req->query('next') == 'before') $query->where('id', '<', $req->query('id', 0));
        if ($req->query('next') == 'after') $query->where('id', '>', $req->query('id', 0));
        if ($req->query('keyword')) {
            $query->where(function($q) use ($req) {
                $q->where('title', 'LIKE', '%'.$req->query('keyword').'%')
                    ->orWhere('content', 'LIKE', '%'.$req->query('keyword').'%')
                    ->orWhereHas('tags', function($tag) use ($req) { $tag->where('value', 'LIKE', '%'.$req->query('keyword').'%'); });
            });
        }
        if ($req->query('language') && $req->query('language') != 'default') {
            $query->orWhereHas('language', function($q) use ($req) { $q->where('value', $req->query('language')); });
        }
        if ($req->query('author')) {
            $query->orWhereHas('author', function($q) use ($req) { $q->where('name', 'LIKE', '%'.$req->query('author').'%'); });
        }
        if ($req->query('mask')) {
        //    $query->orWhereHas('mask', function($q) use ($req) { $q->where('name', 'LIKE', '%'.$req->query('mask').'%'); });
        }
        switch($req->query('sort')) {
            case 'date-asc': $query->orderBy('updated_at'); break;
            case 'date-desc': $query->orderBy('updated_at', 'desc'); break;
        }

        $articles = $query->paginate(1)->appends($req->query());

        return view('components.articles-sample')->with('articles', $articles);

        //return ( $req->expectsJson() ? response()->json($articles) : abort(404) );
    }

    public function create(Request $request)
    {
        $bible = \App\BibleVersion::fetch([
            'bible_version_slug' => $request->query('bible-version'),
            'book_slug' => $request->query('book'),
            'chapter_index' => $request->query('chapter')
        ]) ?? abort(404); // bb not fnd

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
        $popular_articles = null;
        if ($article->published_by) {
            $tag_ids = $article->tags->pluck('id');
            $related = \App\Article::whereHas('tags', function($query) use ($tag_ids){
                $query->whereIn('tags.id', $tag_ids);
            })->get(); // move to model
            $article->related = $related;
            $popular_articles = \App\Article::withCount('views')->whereNotNull('published_by')->orderBy('views_count', 'desc')->limit(10)->get();
            $article->makeViewLog();
        }
        $bible = \App\BibleVersion::fetch([
            'bible_version_id' => $article->bible_version_id,
            'book_index' => $article->book_index,
            'chapter_index' => $article->chapter_index
        ]);

        return view('article')->with(compact('article', 'bible', 'popular_articles'));
    }

    public function edit($id)
    {
        $article = Article::with('tags', 'language')->findOrFail($id);
        if ($article->public) { //nu are un h1 in start
            $article->content = "<h1>$article->title</h1>".$article->content;
        }
		$bible = \App\BibleVersion::fetch([
            'bible_version_id' => $article->bible_version_id,
            'book_index' => $article->book_index,
            'chapter_index' => $article->chapter_index
        ]);

        return view('article-form')->with(compact('article', 'bible'));
    }

    public function update(ValidArticle $request, $id)
    {
        Article::findOrFail($id)->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'content' => $request->content,
            // public f
        ]);
        $article = Article::findOrFail($id);
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
            $article = \App\Article::findOrFail($id)->update([
                'title' => $request->title,
                'meta' => $request->meta,
                'sample' => $request->sample,
                'slug' => $request->slug,
                'content' => $request->content,
                'cite_from' => $request->cite_from,
            ]);
            $article = \App\Article::find($id);
        } else {
            $article = \App\Article::create($request->all());
        }
        $article->setLanguage($request->input('language'));
        $article->addTags(json_decode($request->tags, true));

        return redirect( route('articles.show', $article->slug) );
    }
}

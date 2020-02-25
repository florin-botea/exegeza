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
		$this->middleware('slugify', ['only' => ['store', 'update']]);
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

    public function create(Request $request, string $version_slug, string $book_slug, int $chapter_index = 0)
    {
        $bible = \App\BibleVersion::fetch([
            'bible_version_slug' => $version_slug,
            'book_slug' => $book_slug,
            'chapter_index' => $chapter_index
        ]) ?? abort(404);

        return view('article-form')->with(compact('bible'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValidArticle $request)
    {
        $data = $request->all();
        $data['user_id'] = auth()->user()->id;
        //$data['published_by'] = 1;
        $article = Article::create($data);
        $article->setLanguage($request->input('language'));
        $article->addTags(json_decode($request->tags, true));

        return redirect( route('articles.show', $request->slug) );
    }

    public function show($slug)
    {
        $article = Article::with('tags', 'language', 'author')->where('slug', $slug)->firstOrFail();
        $popular_articles = null;
        if ($article->published_by) {
            $tag_ids = $article->tags->pluck('id');
            $related = \App\Article::whereHas('tags', function($query) use ($tag_ids){
                $query->whereIn('tags.id', $tag_ids);
            })->get();
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
            'meta' => $request->meta,
            'title' => $request->title,
            'slug' => $request->slug,
            'sample' => $request->sample,
            'content' => $request->content,
            'published_by' => 1
        ]);
        $article = Article::findOrFail($id);
        $article->setLanguage($request->input('language'));
        $article->addTags(json_decode($request->tags, true));

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

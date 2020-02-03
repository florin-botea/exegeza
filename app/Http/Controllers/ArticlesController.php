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
        if (!$req->query('all-translations')) {
            $query->where('bible_version_id', $req->query('bible'));
        }
        if (!$req->query('all-languages')) {

        }
        if (!$req->query('all-confessions')) {

        }
        $articles = $query->paginate(1)->appends($req->all());

        return ( $req->expectsJson() ? response()->json($articles) : abort(404) );
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
    public function store(ValidArticle $request)
    {
        $data = $request->all();
        $data['user_id'] = 1;
        $data['published_by'] = 1;
        $article = Article::create($data);
        $article->setLanguage($request->input('language'));
        $article->addTags(json_decode($request->tags, true));

        return redirect( route('articles.show', $request->slug) );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $article = Article::with('tags', 'language', 'author')->where('slug', $slug)->firstOrFail();
        $tag_ids = $article->tags->pluck('id');
        $related = \App\Article::whereHas('tags', function($query) use ($tag_ids){
            $query->whereIn('tags.id', $tag_ids);
        })->get();
        $article->related = $related;
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

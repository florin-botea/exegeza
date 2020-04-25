<?php

namespace App\Http\Controllers;

use App\JqueryComment;
use App\Comment;
use App\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    private function guessModelType()
    {
        if ( request()->query('article') ) {
            return Article::class;
        }
        elseif ( request()->query('app') ) {
            return 'app';
        }
    }

    private function guessModelId()
    {
        return (
            request()->query('article') ?? request()->query('app')
        );
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::with('author.details')->where([
            'model_type' => $this->guessModelType(), 
            'model_id' => $this->guessModelId()
        ])->get();

        $jqueryComments = [];
        foreach ($comments as $comment) {
            $jqueryComments[] = $comment->toJqueryComment();
        }

        return response()->json($jqueryComments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $comment = Comment::create(array_merge($request->all(), [
            'model_type' => $this->guessModelType(),
            'model_id' => $this->guessModelId(),
            'user_id' => Auth::user()->id
        ]));

        //$comments = Comment::with('author.details')->where([
        //    'model_type' => Article::class, 
        //    'model_id' => request()->query('article')
        //])->get();

        //$jqueryComments = [];
        //foreach ($comments as $comment) {
        //    $jqueryComments[] = $comment->toJqueryComment();
        //}
        $jqueryComment = Comment::with('author.details')->find($comment->id)->toJqueryComment();

        return response()->json($jqueryComment);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\JqueryComment;
use App\Comment;
use App\Article;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::with('author.details')->where([
            'model_type' => Article::class, 
            'model_id' => request()->query('article')
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
            'model_type' => Article::class, 
            'model_id' => request()->query('article'),
            'user_id' => 1
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

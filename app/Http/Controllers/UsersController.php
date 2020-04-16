<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\ValidUser;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    public function __construct(Request $request)
    {
        switch ($request->route()->getName()) {
            case 'users.update': $this->middleware('can:update users');
            break;
        }
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $articles = $user->articles()->with('author')->whereNotNull('published_by')->get();
        $unpublished = $user->articles()->with('author', 'bible', 'book')->whereNull('published_by')->get();

        return view('user-page#profile')->with(compact('user', 'articles', 'unpublished'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::with('details.description')->findOrFail($id);
        //$this->inspect($user);
        return view('user-page#profile-edit')->with(compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ValidUser $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        $user->details()->updateOrCreate([], $request->all());
        $user->details->description()->updateOrCreate([], $request->all());

        if ($request->photo && $request->file('photo')) {
            $photo = Storage::put('public/avatars', $request->file('photo'));
            $user->details->photo = Storage::url($photo);
            $user->details->save();
        }

        return redirect( route('users.show', $id) );
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

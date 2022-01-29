<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\ValidUser;
use Illuminate\Support\Facades\Storage;
use Illuminate\Auth\Events\Verified;
use App\Http\Requests\ValidPasswordChange;
use Illuminate\Support\Facades\Hash;
use App\Rules\MatchOldPassword;

class UserController extends Controller
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
        event(new Verified($user));
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

    public function dangerZone($id)
    {
        $user = User::with('deletionRequest')->findOrFail($id);

        return view('user-page#danger')->with('user', $user);
    }

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

    public function changePassword(ValidPasswordChange $request, $id)
    {
        User::find($id)->update(['password'=> Hash::make($request->new_password)]);

        return back()->with('message', [
            'status' => 'success',
            'text' => 'The password has been changed.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $request->validate([
            'password' => ['required', new MatchOldPassword],
        ]);
        $days = 15;

        User::findOrFail($id)->makeDeletionRequest($days);

        return back()->with('message', [
            'status' => 'info',
            'text' => "Your account will be deleted in 15 days",
        ]);
    }

    public function abortDestroy($id)
    {
        User::findOrFail($id)->abortDeletion();

        return back()->with('message', [
            'status' => 'success',
            'text' => "Your account deletion has canceled",
        ]);
    }
}

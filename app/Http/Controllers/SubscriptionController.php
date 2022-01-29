<?php

namespace App\Http\Controllers;

use App\Subscribe;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{

    public function __construct()
    {
        $this->middleware('signed')->only(['verify', 'destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort(404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        $subscription = Subscribe::where('email', $request->email)->first();

        if ($subscription && !$subscription->hasVerifiedEmail()) {
            $subscription->sendEmailVerificationNotification();
            $message = ['status'=>'success', 'text'=>'Adresa de mail a fost inregistrata! Momentan lucram la sistemul de notificari pe mail'];
        }
        elseif ($subscription && $subscription->hasVerifiedEmail()) {
            $message = ['status'=>'info', 'text'=>'Adresa de mail completata este deja abonata!'];
        } else {
            Subscribe::create($request->all())->sendEmailVerificationNotification();
            $message = ['status'=>'success', 'text'=>'Adresa de mail a fost inregistrata! Momentan lucram la sistemul de notificari pe mail'];
        }

        return back()->with('message', $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function show(Subscription $subscription)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscription $subscription)
    {
        abort(404);
    }

    public function verify($id)
    {
        $subscription = Subscribe::find($id);
        if ($subscription && $subscription->hasVerifiedEmail()) {
            $message = ['status'=>'info', 'text'=>'Adresa de mail figureaza deja ca inregistrata.'];
        }
        elseif ($subscription && $subscription->markEmailAsVerified()) {
            $message = ['status'=>'success', 'text'=>'Adresa de mail a fost verificata cu succes.'];
        } else {
            $message = ['status'=>'alert', 'text'=>'A aparut o eroare la verificarea adresei de mail.'];
        }

        return redirect('/')->with('message', $message);
    }

}

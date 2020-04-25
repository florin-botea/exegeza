<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Events\Verified;
use App\User;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function verify($id)
    {
        $this->middleware('signed');

        $user = User::find($id);
        if ($user && $user->hasVerifiedEmail()) {
            $message = ['status'=>'info', 'text'=>'Adresa de mail figureaza deja ca verificata.'];
        }
        elseif ($user && $user->markEmailAsVerified()) {
            $message = ['status'=>'success', 'text'=>'Adresa de mail a fost verificata cu succes.'];
            $user->assignBasicRolesAndPermissions();
        } else {
            $message = ['status'=>'alert', 'text'=>'A aparut o eroare la verificarea adresei de mail.'];
        }

        return redirect('/')->with('message', $message);
    }

    public function resend(Request $request)
    {
        if (!auth()->user()->hasVerifiedEmail()) {
            auth()->user()->sendEmailVerificationNotification();
            $request->session()->flash('message', ['status'=>'success', 'text'=>'Un nou email de confirmare a fost trimis catre adresa '.auth()->user()->email.'.']);
        } else {
            $request->session()->flash('message', ['status'=>'warning', 'text'=>'Adresa de mail este deja confirmata. In cazul in care intampinati probleme tehnice, va rugam sa scrieti un mail la adresa ...']);
        }
        // nu ma intorc inapoi daca e refresh...
        return (strpos(url()->previous(), 'resend') !== false ? redirect('/') : back());
    }
}

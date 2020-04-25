<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords {
        reset as traitReset;
    }

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';

    public function showResetForm($token = null)
    {
        if (is_null($token))
        {
            throw new NotFoundHttpException;    
        }
    
        // Change this to whatever you want ;)
        return view('auth.password-reset')->with('token', $token);
    }

    public function reset(Request $request)
    {
        $this->traitReset($request);

        return redirect('/')->with('message', [
            'status' => 'success',
            'text' => 'Parola actualizata cu succes'
        ]);
    }
}

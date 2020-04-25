<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails {
        sendResetLinkEmail as public traitSendResetLinkEmail;
    }

    public function sendResetLinkEmail(Request $request)
    {
        $this->traitSendResetLinkEmail($request);

        return back()->with('message', [
            'status' => 'success',
            'text' => 'Un email de resetare a fost trimis catre adresa '. $request->email
        ]);
    }
}

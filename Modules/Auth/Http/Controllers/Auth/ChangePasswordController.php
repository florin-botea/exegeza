<?php

namespace Modules\Auth\Http\Controllers\Auth;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ChangePasswordController extends Controller
{
    public function __invoke(Request $request, $id)
    {//TODO
        $request->validate([
            'password' => ['required', 'string', 'min:8'],
            'password_new' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
}

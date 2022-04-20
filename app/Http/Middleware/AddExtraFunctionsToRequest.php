<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Cookie;

class AddExtraFunctionsToRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {dd(12);
        request()->merge(['notifications' => collect([])]);

        $response = $next($request);
        
    $response->headers->setCookie(
        new Cookie('laravelsession',
            $request->session()->getId(),
            time() + 60 * 120,
            '/',
            null,
            config('session.secure'),
            false)
    );
    
    return $response->withCookie(cookie('sss', 'ddd', 60));
    }
}

<?php

namespace App\Http\Middleware;

use Closure;

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
    {
        request()->merge(['notifications' => collect([])]);

        return $next($request);
    }
}

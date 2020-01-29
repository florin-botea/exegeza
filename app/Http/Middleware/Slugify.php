<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;

class Slugify
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
        $slug = Str::slug($request->name ?? $request->title, '-');
        $request->request->add(['slug' => $slug]);

        return $next($request);
    }
}

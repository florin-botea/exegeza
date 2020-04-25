<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Article;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            if ($view->getName() == 'artisan') return;
            $common = Cache::remember('common', 30, function () {
                return [
                    'languages' => \App\Language::all()->pluck('value'),
                    'bibles' => \App\BibleVersion::all()
                ];
            });
            $view->with($common);
        });

        View::composer(['bible', 'article'], function ($view) {
            $uncommon = Cache::remember('lp_', 60, function () {
                return [
                    'last_articles' => Article::whereNotNull('published_by')->orderBy('created_at', 'desc')->limit(10)->get(),
                    'popular_articles' => Article::withCount('views')->whereNotNull('published_by')->orderBy('views_count', 'desc')->limit(10)->get(),
                ];
            });
            $view->with($uncommon);
        });

        Blade::if('route', function ($route = []) {
            $route = is_array($route) ? $route : [$route];
            return in_array(request()->route()->getName(), $route);
        });
    }
}

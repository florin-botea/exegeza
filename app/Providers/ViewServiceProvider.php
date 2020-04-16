<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;
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
            if (! $view->getName() !== 'artisan');
            $view->with([
                'languages' => \App\Language::all()->pluck('value'),
                'bibles' => \App\BibleVersion::all()
            ]);
        });

        View::composer(['bible', 'article'], function ($view) {
            $last_articles = Article::whereNotNull('published_by')->orderBy('created_at', 'desc')->limit(10)->get();
            $popular_articles = Article::withCount('views')->whereNotNull('published_by')->orderBy('views_count', 'desc')->limit(10)->get();
            $view->with(compact('last_articles', 'popular_articles'));
        });
    }
}

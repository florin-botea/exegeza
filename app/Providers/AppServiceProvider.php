<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        \App\BibleVersion::observe(\App\Observers\BibleVersionObserver::class);
        \App\Chapter::observe(\App\Observers\ChapterObserver::class);
        \App\Article::observe(\App\Observers\ArticleObserver::class);
        \App\UserDescription::observe(\App\Observers\UserDescriptionObserver::class);
        \App\User::observe(\App\Observers\UserObserver::class);
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

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

        Blade::component('components.form', 'form');
        Blade::include('components.formgroup', 'formgroup');
        Blade::include('components.formgroups.text', 'text');
        Blade::include('components.formgroups.number', 'number');
        Blade::include('components.formgroups.textarea', 'textarea');
        Blade::include('components.formgroups.select', 'select');
        Blade::include('components.formgroups.submit', 'submit');
        Blade::include('components.formgroups.checkbox', 'checkbox');

        View::share('languages', \App\Language::all()->pluck('value'));
    }
}

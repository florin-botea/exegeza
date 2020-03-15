<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;

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
        Blade::component('components.form', 'form');
        Blade::include('components.formgroup', 'formgroup');
        Blade::include('components.formgroups.text', 'text');
        Blade::include('components.formgroups.number', 'number');
        Blade::include('components.formgroups.textarea', 'textarea');
        Blade::include('components.formgroups.select', 'select');
        Blade::include('components.formgroups.submit', 'submit');
        Blade::include('components.formgroups.checkbox', 'checkbox');

        View::share('languages', \App\Language::all()->pluck('value'));
        View::share('bibles', \App\BibleVersion::all());
    }
}

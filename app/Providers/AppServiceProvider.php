<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Filesystem\Filesystem;
use Illuminate\Support\Facades\Schema;
use PhpTemplates\Integrations\Laravel\ViewFactory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('files', fn () => new Filesystem);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }
}

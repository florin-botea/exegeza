<?php

namespace App\Providers;

use App\Models\Article;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use App\Models\BibleVersion;
use App\Models\Language;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use PhpTemplates\Config;
use PhpTemplates\Directive;
use PhpTemplates\DomEvent;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        Config::set('src_path', config('view.paths.0'));
        Config::set('dest_path', config('view.compiled'));

        Config::set('aliased', [
            'form-group' => 'components/form/form-group',
            // 'x-input-group' => 'components/input-group',
            // 'x-card' => 'components/card',
            // 'x-helper' => 'components/helper',
        ]);

        Directive::add('auth', function() {
            return [
                'p-if' => 'auth()->check()'
            ];
        });

        Directive::add('guest', function() {
            return [
                'p-if' => '!auth()->check()'
            ];
        });

        Directive::add('can', function($permission) {
            return [
                'p-if' => 'auth()->check() && ' . $permission
            ];
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        DomEvent::on('rendering', 'layouts/app', function($t, &$data) {
            $common = Cache::remember('common', 30, function () {
                return [
                    'languages' => Language::all()->pluck('value'),
                    'bibles' => BibleVersion::all(),
                    'errors' => session()->get('errors')
                ];
            });

            $data = array_merge($data, $common);
        });

        // View::composer('*', function ($view) {
        //     if ($view->getName() == 'artisan') return;
        //     $common = Cache::remember('common', 30, function () {
        //         return [
        //             'languages' => Language::all()->pluck('value'),
        //             'bibles' => BibleVersion::all()
        //         ];
        //     });
        //     $view->with($common);
        // });

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

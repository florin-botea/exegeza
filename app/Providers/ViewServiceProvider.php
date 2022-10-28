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
use PhpTemplates\Illuminate\Support\Facades\Template;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        Template::setAlias([
            'l-form' => 'components/form/l-form',
            'form-group' => 'components/form/form-group',
            'csrf' => 'components/form/csrf',
            'card' => 'components/card',
            'modal' => 'components/modal',
            'tabs' => 'components/tabs',
        ]);
        
        Template::setDirective('auth', function() {
            return [
                'p-if' => 'auth()->check()'
            ];
        });

        Template::setDirective('guest', function() {
            return [
                'p-if' => '!auth()->check()'
            ];
        });

        Template::setDirective('logged', function($user_id) {
            return [
                'p-if' => 'auth()->check() && auth()->id() == ' . $user_id
            ];
        });
        
        Template::setDirective('can', function($permission) {
            return [
                'p-if' => 'auth()->check() && auth()->can(' . $permission . ')'
            ];
        });
        Template::setDirective('can-create', function($permission) {
            return [
                'p-if' => '1 || auth()->check() && auth()->can(”create”,' . $permission . ')'
            ];
        });

        Template::setDirective('checked', function($val) {
            return [
                'p-raw' => "$val ? 'checked' : ''"
            ];
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {return;
        /*
        DomEvent::on('rendering', 'layouts/app', function($t, &$data) {
            $common = Cache::remember('common', 30, function () {
                return [
                    'languages' => Language::all()->pluck('value'),
                    //'bibles' => BibleVersion::all(),
                    'errors' => session()->get('errors')
                ];
            });

            $data = array_merge($data, $common);
        });
*/
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
        
        View::composer('article/list', function($data) {
            // TODO: take args and do filter
            return [];
        });

        Blade::if('route', function ($route = []) {
            $route = is_array($route) ? $route : [$route];
            return in_array(request()->route()->getName(), $route);
        });
    }
}

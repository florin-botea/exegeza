<?php

namespace Modules\Auth\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use PhpTemplates\Illuminate\Support\Facades\Template;
use PhpTemplates\Config;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Auth';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'auth';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $sourcePath = module_path($this->moduleName, 'Resources/views');
        $this->loadViewsFrom($sourcePath, $this->moduleNameLower);
        Template::subconfig('auth', $sourcePath);
        
        $this->registerDirectives();
        $this->registerViewEvents();
        
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);
        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);
    }
    
    protected function registerViewEvents()
    {
        Template::on('parsing', 'partials/navbar', function($node) {
            $navbarItems = $node->querySelector('block[name="navbar-items"]');
            $navbarItems->appendChild('
                <div class="ms-auto" p-if="!auth()->check()" _index="0.5">
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#AuthModal">Login</button>
                </div>
                <tpl p-else is="auth:auth/profile-btn" _index="0.5"/>'
            );
        });
        Template::on('parsing', 'layouts/app', function($node) {
            $node->querySelector('body')->appendChild(
                '<tpl is="auth:auth/login-modal" p-if="!auth()->check()" p-bind="$_data"/>'
            );
        });
    }
    
    protected function registerDirectives()
    {
        
    }
}

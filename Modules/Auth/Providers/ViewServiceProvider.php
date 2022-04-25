<?php

namespace Modules\Auth\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use PhpTemplates\Template;
use PhpTemplates\DomEvent;
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
        
        $this->registerDirectives();
        $this->registerViewEvents();
        
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);
        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);
    }
    
    protected function registerViewEvents()
    {
        DomEvent::on('rendering', 'partials/navbar.navbar-items', function($t) {
            $t->slots['navbar-items'][] = view()->raw(function() { 
                if (!auth()->check()) { ?>
                    <div class="ms-auto">
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#AuthModal">Login</button>
                    </div>
                <?php } else {
                    echo view('auth:auth/profile-btn')->render();
                }
            }, ['_index' => 0.5]);
        });
        DomEvent::on('rendering', 'layouts/app', function($t) {
            if (!auth()->check()) {
                $t->slots['modals'][] = view()->get('auth:auth/login-modal', $t->data);
            }
        });
    }
    
    protected function registerDirectives()
    {
        $cfg = view();
        $cfg->addDirective('auth', function() {
            return [
                'p-if' => 'auth()->check()'
            ];
        });

        $cfg->addDirective('guest', function() {
            return [
                'p-if' => '!auth()->check()'
            ];
        });

        $cfg->addDirective('logged', function($user_id) {
            return [
                'p-if' => 'auth()->check() && auth()->id() == ' . $user_id
            ];
        });
        
         $cfg->addDirective('can', function($permission) {
            return [
                'p-if' => 'auth()->check() && ' . $permission
            ];
        });
    }
}

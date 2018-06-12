<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use App\Models\EmailSetting;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local')) {

            // Service Providers
            $this->app->register('Barryvdh\Debugbar\ServiceProvider');

            // Aliases
            $this->app->alias('Debugbar', 'Barryvdh\Debugbar\Facade');

        }else{
            //$this->app['request']->server->set('HTTPS', true);
        }
    }
}

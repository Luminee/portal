<?php

namespace Luminee\User;

use Illuminate\Support\ServiceProvider as _ServiceProvider;

class ServiceProvider extends _ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([realpath(__DIR__.'/../config/user.php') => config_path('LumineeUser.php')]);
    }
    
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(realpath(__DIR__.'/../config/user.php'), 'LumineeUser');
    }
}
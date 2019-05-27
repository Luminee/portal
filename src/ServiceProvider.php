<?php

namespace Luminee\Portal;

use Illuminate\Support\ServiceProvider as _ServiceProvider;
use Tymon\JWTAuth\Providers\JWTAuthServiceProvider;

class ServiceProvider extends _ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([realpath(__DIR__.'/../config/portal.php') => config_path('portal.php')]);
    }
    
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(realpath(__DIR__.'/../config/portal.php'), 'portal');
        $this->app->register(JWTAuthServiceProvider::class);
    }
}
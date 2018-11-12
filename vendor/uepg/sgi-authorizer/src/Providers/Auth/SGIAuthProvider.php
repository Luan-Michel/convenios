<?php

namespace Uepg\SGIAuthorizer\Providers\Auth;

use Uepg\SGIAuthorizer\Providers\Auth\SGIUserProvider;
use Illuminate\Support\ServiceProvider;

class SGIAuthProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $laravel = app();
        if(strpos($laravel::VERSION, '5.1') !== false) {
            $this->app['auth']->extend('sgiauthorizer', function($app) {
                $model = $app['config']['auth.model'];
                return new SGIUserProvider($model);
            });
        } else {
            \Auth::provider('sgiauthorizer', function($app) {
                $model = $app['config']['auth.providers.users.model'];
                return new SGIUserProvider($model);
            });
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
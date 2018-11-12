<?php

namespace Uepg\SGIAuthorizer\Providers;

use Illuminate\Support\ServiceProvider;

class SGIAuthorizerServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
        // registra o caminho das visões deste pacote
        $this->loadViewsFrom(__DIR__ . '/../views', 'sgiauthorizer');

        $this->mergeConfigFrom(
                __DIR__ . '/../config/sgiauthorizer.php', 'sgiauthorizer'
        );

        // define um diretório para publicar as visões e configurações caso o desenvolvedor
        // usuário deste pacote deseje alterá-las na sua aplicação
        $this->publishes([
            __DIR__ . '/../views' => base_path('resources/views/vendor/sgiauthorizer'),
            ], 'views');
        
        $this->publishes([
            __DIR__ . '/../config' => config_path(),
        ], 'config');
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register() {
        $this->app->make('Uepg\SGIAuthorizer\Http\Controllers\LoginController');
        
        $this->commands('Uepg\SGIAuthorizer\Commands\InstallCommand');
        $this->commands('Uepg\SGIAuthorizer\Commands\CheckCommand');
//        $this->app->singleton('Riak\Contracts\Connection', function ($app) {
//            return new Connection(config('riak'));
//        });
    }

}

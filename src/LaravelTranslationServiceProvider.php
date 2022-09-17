<?php

namespace SyscapeSpace\LaravelTranslation;

use Illuminate\Support\ServiceProvider;

class LaravelTranslationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'laravel-translation');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-translation');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('laravel-translation.php'),
            ], 'config');

            $this->publishes([
                __DIR__.'/../database/migrations/create_translations_table.php.stub' => database_path('migrations/'.date('Y_m_d_His').'_create_settings_table.php')
            ], 'migrations');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/laravel-translation'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/laravel-translation'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/laravel-translation'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'laravel-translation');

        // Register the main class to use with the facade
        $this->app->singleton('laravel-translation', function () {
            return new LaravelTranslation;
        });
    }
}

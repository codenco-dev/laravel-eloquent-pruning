<?php

namespace CodencoDev\LaravelEloquentPruning;

use Illuminate\Support\ServiceProvider;

class LaravelEloquentPruningServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/laravel-eloquent-pruning.php' => config_path('laravel-eloquent-pruning.php'),
            ], 'config');

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
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-eloquent-pruning.php', 'laravel-eloquent-pruning');

        // Register the main class to use with the facade
        $this->app->singleton('laravel-eloquent-pruning', function () {
            return new LaravelEloquentPruning;
        });
    }
}

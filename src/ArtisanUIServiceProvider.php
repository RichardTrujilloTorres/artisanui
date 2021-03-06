<?php

namespace Desemax\ArtisanUI;

use Illuminate\Support\ServiceProvider;

// @codeCoverageIgnoreStart
class ArtisanUIServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'desemax');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'desemax');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/artisanui.php', 'artisanui');

        // Register the service the package provides.
        $this->app->singleton('artisanui', function ($app) {
            return new ArtisanUI;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['artisanui'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/artisanui.php' => config_path('artisanui.php'),
        ], 'artisanui.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/desemax'),
        ], 'artisanui.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/desemax'),
        ], 'artisanui.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/desemax'),
        ], 'artisanui.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
// @codeCoverageIgnoreEnd

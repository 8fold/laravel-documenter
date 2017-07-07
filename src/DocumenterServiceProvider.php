<?php

namespace Eightfold\DocumenterLaravel;

use Illuminate\Support\ServiceProvider;

/**
 * Laravel Service Provider
 */
class DocumenterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/views', 'documenter');

        $this->publishes([
            __DIR__.'/config/documenter-laravel.php' => config_path('documenter-laravel.php'),
            __DIR__.'/resources/assets/sass/_documenter.scss' => resource_path('assets/sass/vendor/8fold/documenter/_documenter.scss')
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        include __DIR__.'/routes/web.php';
    }
}

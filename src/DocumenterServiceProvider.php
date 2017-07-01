<?php

namespace Eightfold\Documenter;

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

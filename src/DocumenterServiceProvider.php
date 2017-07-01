<?php

namespace Eightfold\DocumentorLaravel;

use Illuminate\Support\ServiceProvider;

/**
 * Laravel Service Provider
 */
class DocumentorServiceProvider extends ServiceProvider
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
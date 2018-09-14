<?php

namespace MichaelDouglas\MService;

use Illuminate\Support\ServiceProvider;

class MServiceServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        require_once __DIR__ . '/Helpers/Helpers.php';
    }
}

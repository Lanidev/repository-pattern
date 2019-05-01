<?php

namespace Lanidev\Pattern\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class ConfigServiceProvider
 *
 * @package Lanidev\Pattern\Providers
 */
class ConfigServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/pattern.php' => config_path('pattern.php')
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/pattern.php', 'pattern');
    }
}

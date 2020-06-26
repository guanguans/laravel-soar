<?php

/*
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelSoar;

use Illuminate\Support\ServiceProvider;

class SoarServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot()
    {
        $this->setupConfig();
    }

    /**
     * Setup the config.
     */
    protected function setupConfig()
    {
        $source = __DIR__.'/../config/soar.php';

        if ($this->app->runningInConsole()) {
            $this->publishes([$source => config_path('soar.php')], 'laravel-soar');
        }

        $this->mergeConfigFrom($source, 'soar');
    }

    /**
     * Register the provider.
     */
    public function register()
    {
        $this->setupConfig();

        $this->app->singleton(Soar::class, function ($app) {
            return new Soar(config('soar'));
        });

        $this->app->alias(Soar::class, 'soar');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [Soar::class, 'soar'];
    }
}

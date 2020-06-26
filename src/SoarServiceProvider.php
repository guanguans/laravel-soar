<?php

/*
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Overtrue\LaravelPackage;

use Illuminate\Support\ServiceProvider;

class SoarServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/soar.php' => \config_path('soar.php'),
            ], 'laravel-soar-config');
        }

        $this->mergeConfigFrom(__DIR__ . '/../config/soar.php', 'soar');
    }

    public function register()
    {
        // $this->app->singleton(Package::class, function(){
        //    return new Package();
        // });
    }
}

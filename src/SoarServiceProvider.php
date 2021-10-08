<?php

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelSoar;

use Guanguans\LaravelDumpSql\Traits\RegisterDatabaseBuilderMethodAble;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application as LumenApplication;

class SoarServiceProvider extends ServiceProvider
{
    use RegisterDatabaseBuilderMethodAble;

    /**
     * @var bool
     */
    protected $defer = false;

    /**
     * Perform post-registration booting of services.
     */
    public function boot()
    {
        $this->setupConfig();

        $this->registerSoarMethod('score');
        $this->registerSoarMethod('mdExplain');
        $this->registerSoarMethod('htmlExplain');
        $this->registerSoarMethod('pretty');
        $this->registerSoarMethod('help');
    }

    /**
     * Setup the config.
     */
    protected function setupConfig()
    {
        $source = realpath($raw = __DIR__.'/../config/soar.php') ?: $raw;

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('soar.php')], 'laravel-soar');
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('soar');

            $this->app->bindIf(ConnectionInterface::class, function ($app) {
                return $app['db']->connection();
            });

            $this->app->register(\Guanguans\LaravelDumpSql\ServiceProvider::class);
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

    protected function registerSoarMethod(string $methodName)
    {
        $ucfirstMethodName = ucfirst($methodName);

        $this->registerDatabaseBuilderMethod(sprintf('toSoar%s', $ucfirstMethodName), function () use ($methodName) {
            $sql = $this->{config('dumpsql.to_raw_sql', 'toRawSql')}();

            return app('soar')->{$methodName}($sql);
        });

        $this->registerDatabaseBuilderMethod(sprintf('dumpSoar%s', $ucfirstMethodName), function () use ($methodName) {
            $sql = $this->{config('dumpsql.to_raw_sql', 'toRawSql')}();
            if ('pretty' === $methodName || 'help' === $methodName) {
                echo '<pre>';
            }

            echo app('soar')->{$methodName}($sql);
        });

        $this->registerDatabaseBuilderMethod(sprintf('ddSoar%s', $ucfirstMethodName), function () use ($methodName) {
            $sql = $this->{config('dumpsql.to_raw_sql', 'toRawSql')}();
            if ('pretty' === $methodName || 'help' === $methodName) {
                echo '<pre>';
            }

            exit(app('soar')->{$methodName}($sql));
        });
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

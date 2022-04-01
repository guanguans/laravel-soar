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
use Guanguans\LaravelSoar\Macros\QueryBuilderMacro;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\Relation as RelationBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
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
     * Register the provider.
     */
    public function register()
    {
        $this->setupConfig();
        $this->registerMacros();
        $this->registerSoar();
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
     * @throws \ReflectionException
     */
    protected function registerMacros(): void
    {
        QueryBuilder::mixin($queryBuilderMacro = $this->app->make(QueryBuilderMacro::class));
        EloquentBuilder::mixin($queryBuilderMacro);
        RelationBuilder::mixin($queryBuilderMacro);
    }

    /**
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidConfigException
     */
    protected function registerSoar(): void
    {
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

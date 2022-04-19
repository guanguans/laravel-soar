<?php

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelSoar;

use Guanguans\LaravelSoar\Outputs\ClockworkOutput;
use Guanguans\LaravelSoar\Outputs\ConsoleOutput;
use Guanguans\LaravelSoar\Outputs\DebugBarOutput;
use Guanguans\LaravelSoar\Outputs\DumpOutput;
use Guanguans\LaravelSoar\Outputs\JsonOutput;
use Guanguans\LaravelSoar\Outputs\LogOutput;
use Guanguans\LaravelSoar\Outputs\SoarBarOutput;
use Guanguans\LaravelSoar\Support\Macros\QueryBuilderMacro;
use Illuminate\Contracts\Container\Container;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\Relation as RelationBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application as LumenApplication;

class SoarServiceProvider extends ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = false;

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->setupConfig();
        $this->registerMacros();
        $this->registerSingletons();
        $this->registerSoar();
        $this->registerOutputManager();
        $this->registerRoutes();
    }

    public function boot()
    {
        /* @var \Guanguans\LaravelSoar\Bootstrapper $bootstrapper */
        $bootstrapper = $this->app->make(Bootstrapper::class);
        $bootstrapper->bootIf($bootstrapper->isEnabled(), $this->app);
    }

    protected function setupConfig(): void
    {
        $source = realpath($raw = __DIR__.'/../config/soar.php') ?: $raw;

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('soar.php')], 'laravel-soar');
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('soar');
            $this->app->bindIf(ConnectionInterface::class, function ($app) {
                return $app['db']->connection();
            });
        }

        $this->mergeConfigFrom($source, 'soar');
    }

    protected function registerMacros(): void
    {
        QueryBuilder::mixin($queryBuilderMacro = $this->app->make(QueryBuilderMacro::class));
        EloquentBuilder::mixin($queryBuilderMacro);
        RelationBuilder::mixin($queryBuilderMacro);
    }

    protected function registerSingletons(): void
    {
        $this->app->singleton(Bootstrapper::class);
        $this->app->singleton(SoarBar::class);

        $this->app->singleton(ClockworkOutput::class);
        $this->app->singleton(ConsoleOutput::class);
        $this->app->singleton(DebugBarOutput::class);
        $this->app->singleton(DumpOutput::class);
        $this->app->singleton(JsonOutput::class);
        $this->app->singleton(LogOutput::class);
        $this->app->singleton(SoarBarOutput::class);
    }

    protected function registerSoar(): void
    {
        $this->app->singleton(Soar::class, function ($app) {
            return Soar::create(config('soar.options'), config('soar.path'));
        });

        $this->app->alias(Soar::class, 'soar');
    }

    protected function registerOutputManager(): void
    {
        $this->app->singleton(OutputManager::class, function (Container $app) {
            $outputs = collect(config('soar.output'))
                ->map(function ($parameters, $class) use ($app) {
                    ! is_array($parameters) and [$parameters, $class] = [$class, $parameters];

                    return $app->make($class, (array) $parameters);
                })
                ->values()
                ->all();

            return new OutputManager($outputs);
        });

        $this->app->alias(OutputManager::class, 'output_manager');
    }

    protected function registerRoutes(): void
    {
        $this->loadRoutesFrom(realpath(__DIR__.'/Http/routes.php'));
    }

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return [
            Soar::class, 'soar',
            OutputManager::class, 'output_manager',
            Bootstrapper::class,
            SoarBar::class,
        ];
    }
}

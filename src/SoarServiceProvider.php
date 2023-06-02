<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelSoar;

use Guanguans\LaravelSoar\Macros\QueryBuilderMacro;
use Guanguans\LaravelSoar\Outputs\ClockworkOutput;
use Guanguans\LaravelSoar\Outputs\ConsoleOutput;
use Guanguans\LaravelSoar\Outputs\DebugBarOutput;
use Guanguans\LaravelSoar\Outputs\DumpOutput;
use Guanguans\LaravelSoar\Outputs\JsonOutput;
use Guanguans\LaravelSoar\Outputs\LogOutput;
use Guanguans\LaravelSoar\Outputs\NullOutput;
use Guanguans\LaravelSoar\Outputs\SoarBarOutput;
use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Connection;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\Relation as RelationBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Lumen\Application as LumenApplication;

class SoarServiceProvider extends ServiceProvider
{
    protected $defer = false;

    public function register(): void
    {
        $this->setupConfig();
        $this->registerMacros();
        $this->registerSingletons();
        $this->registerSoar();
        $this->registerOutputManager();
        $this->loadRoutes();
    }

    public function boot(): void
    {
        if (config('soar.enabled', false)) {
            $this->app->make(Bootstrapper::class)->boot();
        }
    }

    public function provides()
    {
        return [
            $this->toAlias(OutputManager::class),
            $this->toAlias(Soar::class),
            Bootstrapper::class,
            OutputManager::class,
            Soar::class,
            SoarBar::class,
        ];
    }

    /**
     * @noinspection RealpathInStreamContextInspection
     * @noinspection PhpUndefinedClassInspection
     * @noinspection PhpUndefinedMethodInspection
     */
    protected function setupConfig(): void
    {
        $source = realpath($raw = __DIR__.'/../config/soar.php') ?: $raw;

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('soar.php')], 'laravel-soar');
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('soar');
            $this->app->bindIf(
                ConnectionInterface::class,
                static fn (Container $container): Connection => $container['db']->connection()
            );
        }

        $this->mergeConfigFrom($source, 'soar');
    }

    protected function registerMacros(): void
    {
        $queryBuilderMacro = $this->app->make(QueryBuilderMacro::class);
        EloquentBuilder::mixin($queryBuilderMacro);
        QueryBuilder::mixin($queryBuilderMacro);
        RelationBuilder::mixin($queryBuilderMacro);
    }

    protected function registerSingletons(): void
    {
        foreach (
            [
                Bootstrapper::class,
                QueryBuilderMacro::class,
                SoarBar::class,

                ClockworkOutput::class,
                ConsoleOutput::class,
                DebugBarOutput::class,
                DumpOutput::class,
                JsonOutput::class,
                LogOutput::class,
                NullOutput::class,
                SoarBarOutput::class,
            ] as $class
        ) {
            $this->app->singleton($class);
        }
    }

    protected function registerSoar(): void
    {
        $this->app->singleton(
            Soar::class,
            static fn (): Soar => Soar::create(config('soar.options', []), config('soar.path'))
        );

        $this->app->alias(Soar::class, $this->toAlias(Soar::class));
    }

    protected function registerOutputManager(): void
    {
        $this->app->singleton(
            OutputManager::class,
            static fn (Container $container): OutputManager => collect(config('soar.outputs'))
                ->map(static function ($parameters, $class) use ($container) {
                    if (! \is_array($parameters)) {
                        [$parameters, $class] = [$class, $parameters];
                    }

                    return $container->make($class, (array) $parameters);
                })
                ->values()
                ->pipe(static fn (Collection $collection): OutputManager => new OutputManager($collection->all()))
        );

        $this->app->alias(OutputManager::class, $this->toAlias(OutputManager::class));
    }

    protected function loadRoutes(): void
    {
        $this->loadRoutesFrom(realpath(__DIR__.'/Http/routes.php'));
    }

    /**
     * @param class-string $class
     */
    protected function toAlias(string $class, string $prefix = 'soar.'): string
    {
        $alias = Str::snake(class_basename($class), '.');
        if (Str::startsWith($alias, $prefix)) {
            return $alias;
        }

        return $prefix.$alias;
    }
}

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

use Guanguans\LaravelSoar\Commands\ClearCommand;
use Guanguans\LaravelSoar\Commands\RunCommand;
use Guanguans\LaravelSoar\Commands\ScoreCommand;
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
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\Relation as RelationBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class SoarServiceProvider extends ServiceProvider
{
    public array $singletons = [
        Bootstrapper::class => Bootstrapper::class,
        QueryBuilderMacro::class => QueryBuilderMacro::class,
        SoarBar::class => SoarBar::class,

        ClockworkOutput::class => ClockworkOutput::class,
        ConsoleOutput::class => ConsoleOutput::class,
        DebugBarOutput::class => DebugBarOutput::class,
        DumpOutput::class => DumpOutput::class,
        JsonOutput::class => JsonOutput::class,
        LogOutput::class => LogOutput::class,
        NullOutput::class => NullOutput::class,
        SoarBarOutput::class => SoarBarOutput::class,
    ];

    protected bool $defer = false;

    public function register(): void
    {
        $this->setupConfig();
        $this->registerMacros();
        $this->registerSoar();
        $this->registerOutputManager();
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function boot(): void
    {
        $this->loadRoutes();
        $this->registerCommands();

        if (config('soar.enabled', false)) {
            $this->app->make(Bootstrapper::class)->boot();
        }
    }

    public function provides(): array
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

        if ($this->app->runningInConsole()) {
            $this->publishes([$source => config_path('soar.php')], 'laravel-soar');
        }

        $this->mergeConfigFrom($source, 'soar');
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \ReflectionException
     */
    protected function registerMacros(): void
    {
        $queryBuilderMacro = $this->app->make(QueryBuilderMacro::class);
        EloquentBuilder::mixin($queryBuilderMacro);
        QueryBuilder::mixin($queryBuilderMacro);
        RelationBuilder::mixin($queryBuilderMacro);
    }

    protected function registerSoar(): void
    {
        $this->app->singleton(
            Soar::class,
            static fn (): Soar => Soar::create(
                config('soar.options', []),
                config('soar.binary')
            )->setSudoPassword(config('soar.sudo_password'))
        );

        $this->app->alias(Soar::class, $this->toAlias(Soar::class));
    }

    protected function registerOutputManager(): void
    {
        $this->app->singleton(
            OutputManager::class,
            static fn (Container $container): OutputManager => collect(config('soar.outputs'))
                ->mapWithKeys(static function ($parameters, $class) use ($container): array {
                    if (! \is_array($parameters)) {
                        [$parameters, $class] = [(array) $class, $parameters];
                    }

                    return [$class => $container->make($class, $parameters)];
                })
                ->pipe(static fn (Collection $collection): OutputManager => new OutputManager($collection->all()))
        );

        $this->app->alias(OutputManager::class, $this->toAlias(OutputManager::class));
    }

    protected function loadRoutes(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }

    protected function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ClearCommand::class,
                RunCommand::class,
                ScoreCommand::class,
            ]);
        }
    }

    /**
     * @param class-string $class
     */
    protected function toAlias(string $class, string $prefix = 'soar.'): string
    {
        $alias = Str::snake(class_basename($class), '.');
        if (Str::startsWith($alias, Str::replaceLast('.', '', $prefix))) {
            return $alias;
        }

        return $prefix.$alias;
    }
}

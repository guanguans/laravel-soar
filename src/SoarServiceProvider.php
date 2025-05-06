<?php

declare(strict_types=1);

/**
 * Copyright (c) 2020-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-soar
 */

namespace Guanguans\LaravelSoar;

use Guanguans\LaravelSoar\Commands\ClearCommand;
use Guanguans\LaravelSoar\Commands\RunCommand;
use Guanguans\LaravelSoar\Commands\ScoreCommand;
use Guanguans\LaravelSoar\Mixins\QueryBuilderMixin;
use Guanguans\LaravelSoar\Outputs\ClockworkOutput;
use Guanguans\LaravelSoar\Outputs\ConsoleOutput;
use Guanguans\LaravelSoar\Outputs\DebugBarOutput;
use Guanguans\LaravelSoar\Outputs\DumpOutput;
use Guanguans\LaravelSoar\Outputs\JsonOutput;
use Guanguans\LaravelSoar\Outputs\LogOutput;
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
        QueryBuilderMixin::class => QueryBuilderMixin::class,

        ClockworkOutput::class => ClockworkOutput::class,
        ConsoleOutput::class => ConsoleOutput::class,
        DebugBarOutput::class => DebugBarOutput::class,
        DumpOutput::class => DumpOutput::class,
        JsonOutput::class => JsonOutput::class,
        LogOutput::class => LogOutput::class,
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
        $queryBuilderMixin = $this->app->make(QueryBuilderMixin::class);
        EloquentBuilder::mixin($queryBuilderMixin);
        QueryBuilder::mixin($queryBuilderMixin);
        RelationBuilder::mixin($queryBuilderMixin);
    }

    protected function registerSoar(): void
    {
        $this->app->singleton(
            Soar::class,
            static fn (): Soar => Soar::make(
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
                ->mapWithKeys(static function (array|string $parameters, int|string $class) use ($container): array {
                    if (!\is_array($parameters)) {
                        [$parameters, $class] = [(array) $class, $parameters];
                    }

                    return [$class => $container->make($class, $parameters)];
                })
                ->pipe(static fn (Collection $collection): OutputManager => new OutputManager($collection->all()))
        );

        $this->app->alias(OutputManager::class, $this->toAlias(OutputManager::class));
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

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

use Composer\InstalledVersions;
use Guanguans\LaravelSoar\Commands\ClearCommand;
use Guanguans\LaravelSoar\Commands\RunCommand;
use Guanguans\LaravelSoar\Commands\ScoreCommand;
use Guanguans\LaravelSoar\Mixins\QueryBuilderMixin;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\Relation as RelationBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class SoarServiceProvider extends ServiceProvider
{
    public array $singletons = [
        Bootstrapper::class,
    ];

    /**
     * @noinspection PhpMissingParentCallCommonInspection
     *
     * @throws \ReflectionException
     */
    public function register(): void
    {
        $this->setupConfig();
        $this->registerMixins();
        $this->registerOutputManager();
        $this->registerSoar();
    }

    public function boot(): void
    {
        $this->registerCommands();

        if (config('soar.enabled', false)) {
            $this->app->booted(static fn (Application $application) => $application->make(Bootstrapper::class)->boot());
        }
    }

    /**
     * @noinspection PhpMissingParentCallCommonInspection
     */
    public function provides(): array
    {
        return [
            Bootstrapper::class,
            OutputManager::class,
            Soar::class,
        ];
    }

    /**
     * @noinspection RealpathInStreamContextInspection
     */
    private function setupConfig(): void
    {
        $source = realpath($raw = __DIR__.'/../config/soar.php') ?: $raw;

        if ($this->app->runningInConsole()) {
            $this->publishes([$source => config_path('soar.php')], 'laravel-soar');
        }

        $this->mergeConfigFrom($source, 'soar');
    }

    /**
     * @throws \ReflectionException
     */
    private function registerMixins(): void
    {
        $queryBuilderMixin = new QueryBuilderMixin;
        EloquentBuilder::mixin($queryBuilderMixin);
        QueryBuilder::mixin($queryBuilderMixin);
        RelationBuilder::mixin($queryBuilderMixin);
    }

    private function registerOutputManager(): void
    {
        $this->app->singleton(
            OutputManager::class,
            static fn (Application $application): OutputManager => collect(config('soar.outputs'))
                ->mapWithKeys(static function (array|string $parameters, int|string $class) use ($application): array {
                    if (!\is_array($parameters)) {
                        [$parameters, $class] = [(array) $class, $parameters];
                    }

                    /** @var string $class */
                    return [$class => $application->make($class, $parameters)];
                })
                ->pipe(static fn (Collection $outputs): OutputManager => new OutputManager($outputs->all()))
        );
    }

    private function registerSoar(): void
    {
        $this->app->singleton(
            Soar::class,
            static fn (): Soar => Soar::make(
                config('soar.options', []),
                config('soar.binary')
            )->withSudoPassword(config('soar.sudo_password'))
        );
    }

    private function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ClearCommand::class,
                RunCommand::class,
                ScoreCommand::class,
            ]);

            $this->addSectionToAboutCommand();
        }
    }

    private function addSectionToAboutCommand(): void
    {
        AboutCommand::add(
            str($package = 'guanguans/laravel-soar')->headline()->toString(),
            static fn (): array => collect(['Homepage' => "https://github.com/$package"])
                ->when(
                    class_exists(InstalledVersions::class),
                    static fn (Collection $data): Collection => $data->put(
                        'Version',
                        InstalledVersions::getPrettyVersion($package)
                    )
                )
                ->all()
        );
    }
}

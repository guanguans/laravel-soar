<?php

/** @noinspection MethodVisibilityInspection */

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelSoar\Commands\Concerns;

use Guanguans\LaravelSoar\Soar;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

/**
 * @mixin \Illuminate\Console\Command
 */
trait WithSoarOptions
{
    protected function configure(): void
    {
        $this->setDefinition($this->definition());
    }

    /**
     * @return array<\Symfony\Component\Console\Input\InputArgument|\Symfony\Component\Console\Input\InputOption>
     */
    protected function definition(): array
    {
        return [
            new InputOption(
                'option',
                'o',
                InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY,
                'The option to be passed to Soar(e.g. `--option=-report-type=markdown` or `--option report-type=markdown` or `-o report-type=markdown`)',
            ),
        ];
    }

    protected function debugSoar(): Soar
    {
        $soar = $this->soar();

        if ($this->option('verbose')) {
            $soar->dump();
            $this->newLine();
        }

        return $soar;
    }

    protected function soar(): Soar
    {
        return app(Soar::class)->mergeOptions($this->normalizedSoarOptions());
    }

    protected function normalizedSoarOptions(): array
    {
        return collect($this->option('option'))
            ->mapWithKeys(static function (string $option): array {
                [$key, $value] = Str::of($option)->explode('=', 2)->pad(2, null)->all();

                return [Str::start($key, '-') => $value];
            })
            ->all();
    }
}

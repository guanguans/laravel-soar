<?php

/** @noinspection MethodVisibilityInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2020-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-soar
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
     * @return list<\Symfony\Component\Console\Input\InputArgument|\Symfony\Component\Console\Input\InputOption>
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
            $this->output->newLine();
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

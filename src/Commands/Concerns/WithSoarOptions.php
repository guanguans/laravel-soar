<?php

/** @noinspection MethodVisibilityInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2020-2026 guanguans<ityaozm@gmail.com>
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
use Symfony\Component\Process\Process;

/**
 * @mixin \Illuminate\Console\Command
 */
trait WithSoarOptions
{
    protected function configure(): void
    {
        $this->setDefinition([
            new InputOption(
                'option',
                null,
                InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY,
                'Specify Soar option. Example: `--option=-report-type=markdown` or `--option report-type=markdown`. Can be used multiple times.',
            ),
        ]);
    }

    protected function debugSoar(): Soar
    {
        $soar = $this->soar();

        if ($this->output->isDebug()) {
            $soar->dump();
            $this->output->newLine();
        }

        return $soar;
    }

    protected function soar(): Soar
    {
        return resolve(Soar::class)->withOptions($this->normalizedOptions());
    }

    protected function normalizedOptions(): array
    {
        return collect($this->option('option'))
            ->mapWithKeys(static function (string $option): array {
                [$key, $value] = str($option)->explode('=', 2)->pad(2, null)->all();

                return [Str::start($key, '-') => $value];
            })
            ->all();
    }

    protected function callback(): \Closure
    {
        return function (string $type, string $line): void {
            Process::ERR === $type ? $this->error($line) : $this->info($line);
        };
    }
}

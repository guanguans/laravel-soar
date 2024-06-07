<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelSoar\Commands;

use Guanguans\LaravelSoar\Soar;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class ScoreCommand extends Command
{
    protected $signature = 'soar:score';

    protected $description = 'Get the scores of the given SQL statements';

    /**
     * @noinspection MethodShouldBeFinalInspection
     *
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
     */
    public function handle(): void
    {
        $soar = $this->soar();

        $query = $soar->getQuery();

        for (;;) {
            $query = $query ?: $this->ask('Please input the SQL statements');
            if ($query) {
                break;
            }
        }

        $this->info(tap($soar, $this->soarTapper())->scores($query));
    }

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
                'The option to be passed to Soar(e.g. --option=-report-type=markdown)',
            ),
        ];
    }

    protected function soar(): Soar
    {
        return app(Soar::class)->mergeOptions($this->normalizedSoarOptions());
    }

    protected function soarTapper(): \Closure
    {
        return function (Soar $soar): void {
            if ($this->option('verbose')) {
                $soar->dump();
                $this->newLine();
            }
        };
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

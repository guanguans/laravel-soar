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

class ScoreCommand extends Command
{
    protected $signature = 'soar:score
    {--o|option=* : The option to be passed to Soar(e.g. --option=-report-type=markdown)}
    ';

    protected $description = 'Get the scores of the given SQL statements';

    /**
     * @noinspection MethodShouldBeFinalInspection
     *
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
     */
    public function handle(Soar $soar): void
    {
        for (;;) {
            $sqls = $this->ask('Please input the SQL statements');
            if ($sqls) {
                break;
            }
        }

        echo tap($soar, function (Soar $soar): void {
            $soar->mergeOptions($this->getNormalizeOptions());

            if ($this->option('verbose')) {
                $soar->dump();
            }
        })->scores($sqls);
    }

    private function getNormalizeOptions(): array
    {
        return collect($this->option('option'))
            ->mapWithKeys(static function (string $option): array {
                [$key, $value] = Str::of($option)->explode('=', 2)->pad(2, null)->all();

                return [Str::start($key, '-') => $value];
            })
            ->all();
    }
}

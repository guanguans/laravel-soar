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

class ScoreCommand extends Command
{
    protected $signature = 'soar:score';

    protected $description = 'Get the scores of the given SQL statements';

    /**
     * @noinspection ForgottenDebugOutputInspection
     * @noinspection DebugFunctionUsageInspection
     *
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
     */
    public function handle(Soar $soar): void
    {
        collect($soar->arrayScores($this->ask(
            'Please input the SQL statements'
        )))->each(static fn (array $score) => dump($score));
    }
}

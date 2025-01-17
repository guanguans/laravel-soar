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

use Guanguans\LaravelSoar\Commands\Concerns\WithSoarOptions;
use Illuminate\Console\Command;

class ScoreCommand extends Command
{
    use WithSoarOptions;
    protected $signature = 'soar:score';

    protected $description = 'Get the Soar scores of the given SQL statements';

    /**
     * @noinspection MethodShouldBeFinalInspection
     *
     * @psalm-suppress InvalidPassByReference
     *
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
     */
    public function handle(): void
    {
        $soar = $this->soar();

        $query = $soar->getQuery();

        if (($fstat = fstat(STDIN)) && 0 < $fstat['size']) {
            $query = trim(stream_get_contents(STDIN));
            fclose(STDIN);
        }

        for (;;) {
            $query = $query ?: $this->ask('Please input the SQL statements');

            if ($query) {
                break;
            }
        }

        $this->info($this->debugSoar()->scores($query));
    }
}

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

        if (($fstat = fstat(\STDIN)) && 0 < $fstat['size']) {
            $query = trim(stream_get_contents(\STDIN));
            fclose(\STDIN);
        }

        while (true) {
            $query = $query ?: $this->ask('Please input the SQL statements');

            if ($query) {
                break;
            }
        }

        $this->info($this->debugSoar()->scores($query));
    }
}

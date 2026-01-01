<?php

declare(strict_types=1);

/**
 * Copyright (c) 2020-2026 guanguans<ityaozm@gmail.com>
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

    /** @noinspection ClassOverridesFieldOfSuperClassInspection */
    protected $signature = 'soar:score';

    /** @noinspection ClassOverridesFieldOfSuperClassInspection */
    protected $description = 'Get the Soar scores of the given SQL statements';

    /**
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
     *
     * @noinspection MethodShouldBeFinalInspection
     * @noinspection OffsetOperationsInspection
     * @noinspection SqlResolve
     */
    public function handle(): void
    {
        $query = $this->soar()->getQuery();

        // If the query is not passed in, read from STDIN
        if (($fstat = fstat(\STDIN)) && 0 < $fstat['size']) {
            $query = trim(stream_get_contents(\STDIN));
            fclose(\STDIN);
        }

        while (blank($query)) {
            if (filled($query = $this->ask('Please input the SQL statements', 'select * from foo;'))) {
                break;
            }
        }

        $this->debugSoar()->scores($query, $this->callback());
    }
}

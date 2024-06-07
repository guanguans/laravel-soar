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

class RunCommand extends Command
{
    use WithSoarOptions;
    protected $signature = 'soar:run';

    protected $description = 'Run Soar with the given options';

    /**
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
     */
    public function handle(): void
    {
        $this->info($this->debugSoar()->run());
    }
}

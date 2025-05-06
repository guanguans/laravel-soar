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

class RunCommand extends Command
{
    use WithSoarOptions;

    /** @noinspection ClassOverridesFieldOfSuperClassInspection */
    protected $signature = 'soar:run';

    /** @noinspection ClassOverridesFieldOfSuperClassInspection */
    protected $description = 'Run Soar with the given options';

    /**
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
     */
    public function handle(): void
    {
        $this->info($this->debugSoar()->run());
    }
}

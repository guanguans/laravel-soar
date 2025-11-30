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

namespace Guanguans\LaravelSoar\Listeners;

use Guanguans\LaravelSoar\Bootstrapper;
use Illuminate\Console\Events\CommandFinished;

class OutputScoresListener
{
    public function __construct(private readonly Bootstrapper $bootstrapper) {}

    public function handle(CommandFinished $commandFinished): void
    {
        $this->bootstrapper->outputScores($commandFinished);
    }
}

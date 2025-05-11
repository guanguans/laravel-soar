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
use Guanguans\LaravelSoar\OutputManager;
use Illuminate\Console\Events\CommandFinished;

class OutputScoresListener
{
    public function __construct(
        private Bootstrapper $bootstrapper,
        private OutputManager $outputManager
    ) {}

    /**
     * @throws \JsonException
     */
    public function handle(CommandFinished $commandFinished): void
    {
        $this->outputManager->output($this->bootstrapper->getScores(), $commandFinished);
    }
}

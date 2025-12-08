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

namespace Guanguans\LaravelSoar\Events;

use Guanguans\LaravelSoar\Contracts\OutputContract;
use Illuminate\Console\Events\CommandFinished;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

class OutputtedEvent
{
    public function __construct(
        public readonly OutputContract $output,
        public readonly Collection $scores,
        public readonly CommandFinished|Response $outputter,
        public readonly mixed $result
    ) {}
}

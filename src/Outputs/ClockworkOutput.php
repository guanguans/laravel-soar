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

namespace Guanguans\LaravelSoar\Outputs;

use Illuminate\Console\Events\CommandFinished;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

class ClockworkOutput extends Output
{
    public function shouldOutput(CommandFinished|Response $dispatcher): bool
    {
        return \function_exists('clock');
    }

    public function output(Collection $scores, CommandFinished|Response $dispatcher): mixed
    {
        return clock(...$scores);
    }
}

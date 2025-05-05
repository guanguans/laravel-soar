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

use Illuminate\Support\Collection;

class ClockworkOutput extends Output
{
    public function shouldOutput($dispatcher): bool
    {
        return \function_exists('clock');
    }

    /**
     * @psalm-suppress UndefinedFunction
     */
    public function output(Collection $scores, \Illuminate\Console\Events\CommandFinished|\Symfony\Component\HttpFoundation\Response $dispatcher): void
    {
        clock(...$scores);
    }
}

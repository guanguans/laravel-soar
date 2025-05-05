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

class DumpOutput extends Output
{
    private bool $exit;

    public function __construct(bool $exit = false)
    {
        $this->exit = $exit;
    }

    /**
     * @noinspection ForgottenDebugOutputInspection
     * @noinspection ClosureToArrowFunctionInspection
     * @noinspection DebugFunctionUsageInspection
     */
    public function output(Collection $scores, mixed $dispatcher): void
    {
        $this->exit ? dd(...$scores) : dump(...$scores);
    }
}

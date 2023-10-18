<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
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
     *
     * @param mixed $dispatcher
     */
    public function output(Collection $scores, $dispatcher): void
    {
        $this->exit ? dd(...$scores) : dump(...$scores);
    }
}

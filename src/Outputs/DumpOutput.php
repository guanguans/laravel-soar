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
     * {@inheritDoc}
     *
     * @noinspection ForgottenDebugOutputInspection
     * @noinspection ClosureToArrowFunctionInspection
     * @noinspection DebugFunctionUsageInspection
     */
    public function output(Collection $scores, $dispatcher): void
    {
        $scores
            ->each(static fn (array $score) => dump($score))
            ->tap(function (): void {
                if ($this->exit) {
                    exit(1); // @codeCoverageIgnore
                }
            });
    }
}

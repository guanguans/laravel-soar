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

class ErrorLogOutput extends Output
{
    public function __construct(
        protected int $messageType = 0,
        protected string $destination = '',
        protected string $extraHeaders = ''
    ) {}

    /**
     * @noinspection ForgottenDebugOutputInspection
     * @noinspection DebugFunctionUsageInspection
     *
     * @throws \JsonException
     */
    public function output(Collection $scores, mixed $dispatcher): void
    {
        error_log($this->hydrateScores($scores), $this->messageType, $this->destination, $this->extraHeaders);
    }
}

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
    protected int $messageType;
    protected string $destination;
    protected string $extraHeaders;

    public function __construct(int $messageType = 0, string $destination = '', string $extraHeaders = '')
    {
        $this->messageType = $messageType;
        $this->destination = $destination;
        $this->extraHeaders = $extraHeaders;
    }

    /**
     * @noinspection ForgottenDebugOutputInspection
     * @noinspection DebugFunctionUsageInspection
     *
     * @param mixed $dispatcher
     *
     * @throws \JsonException
     */
    public function output(Collection $scores, $dispatcher): void
    {
        error_log($this->hydrateScores($scores), $this->messageType, $this->destination, $this->extraHeaders);
    }
}

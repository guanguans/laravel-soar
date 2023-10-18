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

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
     * {@inheritDoc}
     *
     * @throws \JsonException
     *
     * @noinspection ForgottenDebugOutputInspection
     * @noinspection DebugFunctionUsageInspection
     */
    public function output(Collection $scores, $dispatcher): void
    {
        $scores->each(fn (array $score): bool => error_log(
            $score['Summary'].PHP_EOL.to_pretty_json($score),
            $this->messageType,
            $this->destination,
            $this->extraHeaders,
        ));
    }
}

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

use Illuminate\Log\LogManager;
use Illuminate\Support\Collection;

class LogOutput extends Output
{
    protected LogManager $logger;

    protected string $channel;

    public function __construct(LogManager $logger, string $channel = 'daily')
    {
        $this->logger = $logger;
        $this->channel = $channel;
    }

    /**
     * {@inheritDoc}
     *
     * @throws \JsonException
     */
    public function output(Collection $scores, $dispatcher): void
    {
        $scores->each(fn (array $score) => $this->logger->channel($this->channel)->warning(
            $score['Summary'].PHP_EOL.to_pretty_json($score)
        ));
    }
}

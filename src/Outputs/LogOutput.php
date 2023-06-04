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
use Psr\Log\LoggerInterface;

class LogOutput extends Output
{
    protected LoggerInterface $logger;

    protected string $channel;

    public function __construct(LoggerInterface $logger, string $channel = 'daily')
    {
        $this->logger = $logger;
        $this->channel = $channel;
    }

    public function output(Collection $scores, $dispatcher): void
    {
        $scores->each(fn (array $score) => $this->logger->channel($this->channel)->warning(
            $score['Summary'].PHP_EOL.to_pretty_json($score)
        ));
    }
}

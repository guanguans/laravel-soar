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
    protected \Psr\Log\LoggerInterface $logger;

    protected string $channel;

    public function __construct(LoggerInterface $logger, $channel = 'daily')
    {
        $this->logger = $logger;
        $this->channel = $channel;
    }

    public function output(Collection $scores, $event): void
    {
        $scores->each(function (array $score): void {
            unset($score['Basic']);
            $this->logger->channel($this->channel)->warning($score['Summary'].PHP_EOL.to_pretty_json($score));
        });
    }
}

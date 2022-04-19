<?php

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
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @var string
     */
    protected $channel;

    public function __construct(LoggerInterface $logger, $channel = 'daily')
    {
        $this->logger = $logger;
        $this->channel = $channel;
    }

    /**
     * {@inheritdoc}
     */
    public function output(Collection $scores, $event)
    {
        $scores->each(function (array $score) {
            unset($score['Basic']);
            $this->logger->channel($this->channel)->warning($score['Summary'].PHP_EOL.to_pretty_json($score));
        });
    }
}

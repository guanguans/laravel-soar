<?php

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelSoar\Outputs;

use Barryvdh\Debugbar\Facade as LaravelDebugbar;
use DebugBar\DataCollector\MessagesCollector;
use Illuminate\Support\Collection;

class DebugBarOutput extends Output
{
    /**
     * @var \DebugBar\DataCollector\MessagesCollector
     */
    protected static $collector;

    /**
     * @param \Symfony\Component\HttpFoundation\Response $response
     *
     * @return mixed
     */
    public function output(Collection $scores, $response)
    {
        if (! $this->shouldOutputInDebugBar($response)) {
            return;
        }

        $scores->tap(function ($scores) use (&$collector) {
            $collector = $this->createCollector();
        })->each(function (array $score) use ($collector) {
            unset($score['Basic']);
            $collector->addMessage(
                $score['Summary'].PHP_EOL.json_encode($score, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
                'info',
                false
            );
        });
    }

    protected function createCollector(): MessagesCollector
    {
        self::$collector instanceof MessagesCollector or self::$collector = new MessagesCollector('Soar Scores');
        LaravelDebugbar::hasCollector(self::$collector->getName()) or LaravelDebugbar::addCollector(self::$collector);

        return self::$collector;
    }
}

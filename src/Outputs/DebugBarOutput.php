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
     * @var bool
     */
    private static $outputted = false;

    /**
     * @param \Symfony\Component\HttpFoundation\Response $response
     *
     * @return mixed
     */
    public function output(Collection $scores, $response)
    {
        if (! $this->shouldOutput($response)) {
            return;
        }

        $scores->tap(function ($scores) use (&$collector) {
            $collector = $this->createCollector();
        })->each(function (array $score) use ($collector) {
            unset($score['Basic']);
            $collector->addMessage($score['Summary'].PHP_EOL.to_pretty_json($score), 'warning', false);
        });

        self::$outputted = true;
    }

    public static function isOutputted()
    {
        return self::$outputted;
    }

    protected function shouldOutput($response): bool
    {
        return $this->isResponse($response) &&
               class_exists('Barryvdh\Debugbar\Facade') &&
               \Barryvdh\Debugbar\Facade::isEnabled();
    }

    protected function createCollector(): MessagesCollector
    {
        self::$collector instanceof MessagesCollector or self::$collector = new MessagesCollector('Soar Scores');
        LaravelDebugbar::hasCollector(self::$collector->getName()) or LaravelDebugbar::addCollector(self::$collector);

        return self::$collector;
    }
}

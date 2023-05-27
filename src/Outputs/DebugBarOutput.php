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

use DebugBar\DataCollector\MessagesCollector;
use Illuminate\Support\Collection;

class DebugBarOutput extends Output
{
    protected static \DebugBar\DataCollector\MessagesCollector $collector;

    private static bool $outputted = false;

    public function output(Collection $scores, $dispatcher): void
    {
        if (! $this->shouldOutput($dispatcher)) {
            return;
        }

        $scores->tap(function ($scores) use (&$collector): void {
            $collector = $this->createCollector();
        })->each(static function (array $score) use ($collector): void {
            unset($score['Basic']);
            $collector->addMessage($score['Summary'].PHP_EOL.to_pretty_json($score), 'warning', false);
        });

        self::$outputted = true;
    }

    public static function isOutputted(): bool
    {
        return self::$outputted;
    }

    protected function shouldOutput($dispatcher): bool
    {
        return $this->isHtmlResponse($dispatcher)
               && class_exists('\Barryvdh\Debugbar\LaravelDebugbar')
               && app(\Barryvdh\Debugbar\LaravelDebugbar::class)->isEnabled();
    }

    protected function createCollector(): MessagesCollector
    {
        self::$collector instanceof MessagesCollector
        or self::$collector = new MessagesCollector('Soar Scores');

        app(\Barryvdh\Debugbar\LaravelDebugbar::class)->hasCollector(self::$collector->getName())
        or app(\Barryvdh\Debugbar\LaravelDebugbar::class)->addCollector(self::$collector);

        return self::$collector;
    }
}

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

use Barryvdh\Debugbar\LaravelDebugbar;
use DebugBar\DataCollector\MessagesCollector;
use Illuminate\Support\Collection;

class DebugBarOutput extends Output
{
    protected static ?MessagesCollector $collector = null;

    private static bool $outputted = false;

    public function output(Collection $scores, $dispatcher): void
    {
        if (! $this->shouldOutput($dispatcher)) {
            return;
        }

        $scores
            ->tap(function () use (&$collector): void {
                $collector = $this->createCollector();
            })
            ->each(static function (array $score) use ($collector): void {
                $collector->addMessage($score['Summary'].PHP_EOL.to_pretty_json($score), 'warning', false);
            })
            ->tap(static function (): void {
                self::$outputted = true;
            });
    }

    public static function isOutputted(): bool
    {
        return self::$outputted;
    }

    protected function shouldOutput($dispatcher): bool
    {
        return $this->isHtmlResponse($dispatcher)
               && class_exists(LaravelDebugbar::class)
               && app(LaravelDebugbar::class)->isEnabled();
    }

    protected function createCollector(): MessagesCollector
    {
        if (! self::$collector instanceof MessagesCollector) {
            self::$collector = new MessagesCollector('Soar Scores');
        }

        if (! app(LaravelDebugbar::class)->hasCollector(self::$collector->getName())) {
            app(LaravelDebugbar::class)->addCollector(self::$collector);
        }

        return self::$collector;
    }
}

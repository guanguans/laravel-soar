<?php

declare(strict_types=1);

/**
 * Copyright (c) 2020-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-soar
 */

namespace Guanguans\LaravelSoar\Outputs;

use Barryvdh\Debugbar\LaravelDebugbar;
use DebugBar\DataCollector\MessagesCollector;
use Illuminate\Support\Collection;

class DebugBarOutput extends Output
{
    protected string $name;
    protected string $label;
    private static bool $outputted = false;

    public function __construct(string $name = 'Soar Scores', string $label = 'warning')
    {
        $this->name = $name;
        $this->label = $label;
    }

    public function shouldOutput($dispatcher): bool
    {
        // app(LaravelDebugbar::class)->isEnabled()
        return class_exists(LaravelDebugbar::class)
            && app()->has(LaravelDebugbar::class)
            && $this->isHtmlResponse($dispatcher);
    }

    /**
     * @param mixed $dispatcher
     *
     * @throws \JsonException
     */
    public function output(Collection $scores, $dispatcher): void
    {
        $laravelDebugbar = app(LaravelDebugbar::class);

        if (!$laravelDebugbar->hasCollector($this->name)) {
            $laravelDebugbar->addCollector(new MessagesCollector($this->name));
        }

        $scores->each(fn (array $score) => $laravelDebugbar[$this->name]->addMessage(
            $this->hydrateScore($score),
            $this->label,
            false
        ))->tap(static fn (): bool => self::$outputted = true);
    }

    public static function isOutputted(): bool
    {
        return self::$outputted;
    }
}

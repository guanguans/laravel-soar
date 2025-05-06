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
    private static bool $outputted = false;

    public function __construct(
        protected string $name = 'Soar Scores',
        protected string $label = 'warning'
    ) {}

    public function shouldOutput($dispatcher): bool
    {
        // app(LaravelDebugbar::class)->isEnabled()
        return class_exists(LaravelDebugbar::class)
            && app()->has(LaravelDebugbar::class)
            && $this->isHtmlResponse($dispatcher);
    }

    /**
     * @throws \JsonException
     */
    public function output(Collection $scores, mixed $dispatcher): void
    {
        $laravelDebugbar = app(LaravelDebugbar::class);

        if (!$laravelDebugbar->hasCollector($this->name)) {
            $laravelDebugbar->addCollector(new MessagesCollector($this->name));
        }

        $scores->each(fn (array $score) => $laravelDebugbar[$this->name]->addMessage(
            $this->hydrateScore($score),
            $this->label,
            false
        ));
    }
}

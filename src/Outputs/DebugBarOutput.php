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
use Illuminate\Console\Events\CommandFinished;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

class DebugBarOutput extends Output
{
    public function __construct(
        protected string $name = 'Soar Scores',
        protected string $label = 'warning'
    ) {}

    public function shouldOutput(CommandFinished|Response $dispatcher): bool
    {
        // app(LaravelDebugbar::class)->isEnabled()
        return class_exists(LaravelDebugbar::class)
            && app()->has(LaravelDebugbar::class)
            && $this->isHtmlResponse($dispatcher);
    }

    /**
     * @throws \JsonException
     */
    public function output(Collection $scores, CommandFinished|Response $dispatcher): mixed
    {
        $debugBar = resolve(LaravelDebugbar::class);

        \assert($debugBar instanceof LaravelDebugbar);

        if (!$debugBar->hasCollector($this->name)) {
            $debugBar->addCollector(new MessagesCollector($this->name));
        }

        $scores->each(fn (array $score) => $debugBar->getCollector($this->name)->addMessage(
            $this->hydrateScore($score),
            $this->label,
            false
        ));

        return $debugBar;
    }
}

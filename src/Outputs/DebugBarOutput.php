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

class DebugBarOutput extends AbstractOutput
{
    public function __construct(
        private string $name = 'Soar Scores',
        private string $label = 'warning'
    ) {}

    /**
     * @noinspection PhpMissingParentCallCommonInspection
     */
    public function shouldOutput(CommandFinished|Response $outputter): bool
    {
        return class_exists(LaravelDebugbar::class)
            && app()->has(LaravelDebugbar::class)
            && resolve(LaravelDebugbar::class)->isEnabled()
            && $this->isHtmlResponse($outputter);
    }

    /**
     * @noinspection PhpPossiblePolymorphicInvocationInspection
     *
     * @throws \DebugBar\DebugBarException
     * @throws \JsonException
     */
    public function output(Collection $scores, CommandFinished|Response $outputter): LaravelDebugbar
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

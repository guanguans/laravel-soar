<?php

/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUndefinedNamespaceInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2020-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-soar
 */

namespace Guanguans\LaravelSoar\Outputs;

use DebugBar\DataCollector\MessagesCollector;
use Fruitcake\LaravelDebugbar\LaravelDebugbar;
use Illuminate\Console\Events\CommandFinished;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

class DebugBarOutput extends AbstractOutput
{
    public function __construct(
        private readonly string $name = 'Soar Scores',
        private readonly string $label = 'warning',
        private readonly array $context = [],
    ) {}

    /**
     * @noinspection PhpMissingParentCallCommonInspection
     */
    public function shouldOutput(CommandFinished|Response $outputter): bool
    {
        return class_exists(LaravelDebugbar::class)
            && app()->has(LaravelDebugbar::class)
            // && resolve(LaravelDebugbar::class)->isEnabled()
            && $this->isHtmlResponse($outputter);
    }

    /**
     * @throws \DebugBar\DebugBarException
     * @throws \JsonException
     *
     * @noinspection PhpPossiblePolymorphicInvocationInspection
     */
    public function output(Collection $scores, CommandFinished|Response $outputter): LaravelDebugbar
    {
        $laravelDebugbar = resolve(LaravelDebugbar::class);
        \assert($laravelDebugbar instanceof LaravelDebugbar);

        if (!$laravelDebugbar->hasCollector($this->name)) {
            $laravelDebugbar->addCollector(new MessagesCollector($this->name));
        }

        $scores->each(
            fn (array $score) => $laravelDebugbar
                ->getCollector($this->name)
                ->addMessage($this->hydrateScore($score), $this->label, $this->context)
        );

        return $laravelDebugbar;
    }
}

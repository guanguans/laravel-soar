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

use Barryvdh\Debugbar\LaravelDebugbar;
use Barryvdh\Debugbar\ServiceProvider;
use DebugBar\DataCollector\MessagesCollector;
use Illuminate\Console\Events\CommandFinished;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

class DebugBarOutput extends AbstractOutput
{
    public function __construct(
        private readonly string $name = 'Soar Scores',
        private readonly string $label = 'warning'
    ) {}

    /**
     * @noinspection PhpMissingParentCallCommonInspection
     */
    public function shouldOutput(CommandFinished|Response $outputter): bool
    {
        return class_exists($this->laravelDebugbarClass())
            && app()->has($this->laravelDebugbarClass())
            // && resolve($this->laravelDebugbarClass())->isEnabled()
            && $this->isHtmlResponse($outputter);
    }

    /**
     * @throws \DebugBar\DebugBarException
     * @throws \JsonException
     *
     * @noinspection PhpPossiblePolymorphicInvocationInspection
     */
    public function output(Collection $scores, CommandFinished|Response $outputter): \Fruitcake\LaravelDebugbar\LaravelDebugbar|LaravelDebugbar
    {
        $debugBar = resolve($this->laravelDebugbarClass());
        \assert($debugBar instanceof \Fruitcake\LaravelDebugbar\LaravelDebugbar || $debugBar instanceof LaravelDebugbar);

        if (!$debugBar->hasCollector($this->name)) {
            $debugBar->addCollector(new MessagesCollector($this->name));
        }

        $scores->each(fn (array $score) => $debugBar->getCollector($this->name)->addMessage(
            $this->hydrateScore($score),
            $this->label,
            $this->laravelDebugbarClass() === LaravelDebugbar::class ? false : []
        ));

        return $debugBar;
    }

    /**
     * @api
     *
     * @return class-string<\Fruitcake\LaravelDebugbar\ServiceProvider|ServiceProvider>
     */
    public static function laravelDebugbarServiceProviderClass(): string
    {
        return class_exists($class = \Fruitcake\LaravelDebugbar\ServiceProvider::class) ? $class : ServiceProvider::class;
    }

    /**
     * @return class-string<\Fruitcake\LaravelDebugbar\LaravelDebugbar|LaravelDebugbar>
     */
    private function laravelDebugbarClass(): string
    {
        return class_exists($class = \Fruitcake\LaravelDebugbar\LaravelDebugbar::class) ? $class : LaravelDebugbar::class;
    }
}

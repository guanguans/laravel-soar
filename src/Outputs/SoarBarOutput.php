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

use DebugBar\DataCollector\MessagesCollector;
use Guanguans\LaravelSoar\SoarBar;
use Illuminate\Support\Collection;

class SoarBarOutput extends Output
{
    protected string $name;
    protected string $label;

    public function __construct(string $name = 'Scores', string $label = 'warning')
    {
        $this->name = $name;
        $this->label = $label;
    }

    public function shouldOutput($dispatcher): bool
    {
        return !DebugBarOutput::isOutputted() && $this->isHtmlResponse($dispatcher);
    }

    /**
     * @param mixed $dispatcher
     *
     * @throws \JsonException
     */
    public function output(Collection $scores, $dispatcher): void
    {
        $soarBar = app(SoarBar::class);

        if (!$soarBar->hasCollector($this->name)) {
            $soarBar->addCollector(new MessagesCollector($this->name));
        }

        $scores->each(fn (array $score) => $soarBar[$this->name]->addMessage(
            $this->hydrateScore($score),
            $this->label,
            false
        ));

        /** @var \Symfony\Component\HttpFoundation\Response $dispatcher */
        $content = $dispatcher->getContent();
        $head = $soarBar->getJavascriptRenderer()->renderHead();
        $widget = $soarBar->getJavascriptRenderer()->render();

        // Try to put the js/css directly before the </head>
        $pos = strripos($content, '</head>');
        false !== $pos
            ? $content = substr($content, 0, $pos).$head.substr($content, $pos) // @codeCoverageIgnore
            : $widget = $head.$widget; // Append the head before the widget

        // Try to put the widget at the end, directly before the </body>
        $pos = strripos($content, '</body>');
        $content = false !== $pos ? substr($content, 0, $pos).$widget.substr($content, $pos) : $content.$widget;

        // Update the new content and reset the content length
        $dispatcher->setContent($content);
        $dispatcher->headers->remove('Content-Length');
    }
}

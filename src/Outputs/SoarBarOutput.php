<?php

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelSoar\Outputs;

use Guanguans\LaravelSoar\SoarBar;
use Illuminate\Support\Collection;

class SoarBarOutput extends Output
{
    /**
     * @var \Guanguans\LaravelSoar\SoarBar
     */
    private $debugBar;

    /**
     * @var \DebugBar\JavascriptRenderer
     */
    private $renderer;

    public function __construct(SoarBar $debugBar)
    {
        $this->debugBar = $debugBar;
        $this->renderer = $debugBar->getJavascriptRenderer();
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Response $operator
     *
     * @return mixed
     */
    public function output(Collection $scores, $operator)
    {
        if (! $this->shouldOutputInSoarBar($operator)) {
            return;
        }

        $scores->each(function (array $score) {
            unset($score['Basic']);
            // warning error info
            $this->debugBar['messages']->addMessage(
                $score['Summary'].PHP_EOL.json_encode($score, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
                'warning',
                false
            );
        });

        $content = $operator->getContent();
        $head = $this->renderer->renderHead();
        $widget = $this->renderer->render();

        // Try to put the js/css directly before the </head>
        $pos = strripos($content, '</head>');
        if (false !== $pos) {
            $content = substr($content, 0, $pos).$head.substr($content, $pos);
        } else {
            // Append the head before the widget
            $widget = $head.$widget;
        }

        // Try to put the widget at the end, directly before the </body>
        $pos = strripos($content, '</body>');
        if (false !== $pos) {
            $content = substr($content, 0, $pos).$widget.substr($content, $pos);
        } else {
            $content = $content.$widget;
        }

        // Update the new content and reset the content length
        $operator->setContent($content);
        $operator->headers->remove('Content-Length');
    }
}

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

use DebugBar\JavascriptRenderer;
use Guanguans\LaravelSoar\SoarBar;
use Illuminate\Support\Collection;

class SoarBarOutput extends Output
{
    private SoarBar $soarBar;

    private JavascriptRenderer $javascriptRenderer;

    public function __construct(SoarBar $soarBar)
    {
        $this->soarBar = $soarBar;
        $this->javascriptRenderer = $soarBar->getJavascriptRenderer();
    }

    public function output(Collection $scores, $dispatcher): void
    {
        if (! $this->shouldOutput($dispatcher)) {
            return;
        }

        $scores->each(function (array $score): void {
            // warning error info
            $this->soarBar['scores']->addMessage($score['Summary'].PHP_EOL.to_pretty_json($score), 'warning', false);
        });

        $content = $dispatcher->getContent();
        $head = $this->javascriptRenderer->renderHead();
        $widget = $this->javascriptRenderer->render();

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
        $content = false !== $pos ? substr($content, 0, $pos).$widget.substr($content, $pos) : $content.$widget;

        // Update the new content and reset the content length
        $dispatcher->setContent($content);
        $dispatcher->headers->remove('Content-Length');
    }

    protected function shouldOutput($dispatcher): bool
    {
        return ! DebugBarOutput::isOutputted()
               && $this->isHtmlResponse($dispatcher);
    }
}

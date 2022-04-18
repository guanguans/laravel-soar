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
     * @param \Illuminate\Foundation\Http\Events\RequestHandled $requestHandled
     *
     * @return mixed
     */
    public function output(Collection $scores, $requestHandled)
    {
        if (! $this->shouldOutput($requestHandled)) {
            return;
        }

        $scores->each(function (array $score) {
            unset($score['Basic']);
            // warning error info
            $this->debugBar['scores']->addMessage($score['Summary'].PHP_EOL.to_pretty_json($score), 'warning', false);
        });

        $content = $requestHandled->getContent();
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
        $requestHandled->setContent($content);
        $requestHandled->headers->remove('Content-Length');
    }

    protected function shouldOutput($requestHandled): bool
    {
        return ! DebugBarOutput::isOutputted()
            && $this->isHtmlResponse($requestHandled);
    }
}

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
    public function __construct(SoarBar $debugBar)
    {
        $this->debugBar = $debugBar;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Response $response
     *
     * @return mixed
     */
    public function output(Collection $scores, $response)
    {
        if (! $this->shouldOutputInHtmlResponse($response) || $this->shouldOutputInDebugBar($response)) {
            return;
        }

        $debugBar = $this->debugBar;
        $renderer = $debugBar->getJavascriptRenderer();
        $scores->each(function (array $score) use ($debugBar) {
            unset($score['Basic']);
            $debugBar['messages']->addMessage(
                $score['Summary'].PHP_EOL.json_encode($score, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
                'info',
                false
            );
        });

        $content = $response->getContent();
        $head = $renderer->renderHead();
        $widget = $renderer->render();

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
        $response->setContent($content);
        $response->headers->remove('Content-Length');
    }
}

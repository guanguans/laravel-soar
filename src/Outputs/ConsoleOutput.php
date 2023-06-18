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

use Illuminate\Support\Collection;

class ConsoleOutput extends Output
{
    protected string $method;

    public function __construct(string $method = 'warn')
    {
        $this->method = $method;
    }

    public function output(Collection $scores, $dispatcher): void
    {
        if (! $this->isHtmlResponse($dispatcher)) {
            return;
        }

        $js = $this->toJavascript($scores);
        $content = $dispatcher->getContent();

        // Try to put the widget at the end, directly before the </body>
        $pos = strripos($content, '</body>');
        $content = false !== $pos ? substr($content, 0, $pos).$js.substr($content, $pos) : $content.$js;

        // Update the new content and reset the content length
        $dispatcher->setContent($content);
        $dispatcher->headers->remove('Content-Length');
    }

    /**
     * @throws \JsonException
     */
    protected function toJavascript(Collection $scores): string
    {
        return sprintf(
            '<script type="text/javascript">console.%s(`%s`);</script>',
            $this->method,
            str_replace('`', '\`', $this->hydrateScores($scores)),
        );
    }
}

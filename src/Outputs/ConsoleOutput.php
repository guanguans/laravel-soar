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

use Illuminate\Support\Collection;

class ConsoleOutput extends Output
{
    protected string $method;

    public function __construct(string $method = 'warn')
    {
        $this->method = $method;
    }

    public function shouldOutput($dispatcher): bool
    {
        return $this->isHtmlResponse($dispatcher);
    }

    public function output(Collection $scores, $dispatcher): void
    {
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
        return \sprintf(
            '<script type="text/javascript">console.%s(`%s`);</script>',
            $this->method,
            str_replace('`', '\`', $this->hydrateScores($scores)),
        );
    }
}

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

use Illuminate\Console\Events\CommandFinished;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

class ConsoleOutput extends AbstractOutput
{
    public function __construct(private string $method = 'warn') {}

    /**
     * @noinspection PhpMissingParentCallCommonInspection
     */
    public function shouldOutput(CommandFinished|Response $outputter): bool
    {
        return $this->isHtmlResponse($outputter);
    }

    /**
     * @throws \JsonException
     */
    public function output(Collection $scores, CommandFinished|Response $outputter): Response
    {
        \assert($outputter instanceof Response);

        $js = $this->toJavaScript($scores);
        $content = $outputter->getContent();

        // Try to put the widget at the end, directly before the </body>
        $pos = strripos($content, '</body>');
        $content = false !== $pos ? substr($content, 0, $pos).$js.substr($content, $pos) : $content.$js;

        // Update the new content and reset the content length
        $outputter->setContent($content);
        $outputter->headers->remove('Content-Length');

        return $outputter;
    }

    /**
     * @throws \JsonException
     */
    private function toJavaScript(Collection $scores): string
    {
        return \sprintf(
            /** @lang JavaScript */
            '<script type="text/javascript">console.%s(`%s`);</script>',
            $this->method,
            str_replace('`', '\`', $this->hydrateScores($scores)),
        );
    }
}

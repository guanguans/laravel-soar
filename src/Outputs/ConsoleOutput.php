<?php

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
    public function output(Collection $scores, $operator)
    {
        if (! $this->shouldOutputInHtmlResponse($operator)) {
            return;
        }

        $content = $operator->getContent();
        $outputContent = $this->getOutputContent($scores);

        $content = false === ($pos = strripos($content, '</body>'))
        ? $content.$outputContent
        : substr($content, 0, $pos).$outputContent.substr($content, $pos);

        // Update the new content and reset the content length
        $operator->setContent($content);
        $operator->headers->remove('Content-Length');
    }

    protected function getOutputContent(Collection $scores)
    {
        $output = '<script type="text/javascript">';
        foreach ($scores as $score) {
            $output .= sprintf("console.warn(JSON.parse('%s')); ", addslashes(json_encode($score, JSON_UNESCAPED_UNICODE)));
        }
        $output .= '</script>';

        return $output;
    }
}

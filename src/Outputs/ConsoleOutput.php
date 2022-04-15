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

        $js = $this->transformToJs($scores);
        $content = $operator->getContent();
        $content = false === ($pos = strripos($content, '</body>'))
        ? $content.$js
        : substr($content, 0, $pos).$js.substr($content, $pos);

        $operator->setContent($content);
        $operator->headers->remove('Content-Length');
    }

    protected function transformToJs(Collection $scores)
    {
        return $scores->pipe(function ($scores) {
            $js = $scores->reduce(function ($js, $score) {
                unset($score['Basic']);
                $score = str_replace('`', '\`', var_output($score, true));

                return $js.<<<JS
console.warn(`
$score
`);
JS;
            }, '');

            return <<<JS
<script type="text/javascript">$js</script>
JS;
        });
    }
}

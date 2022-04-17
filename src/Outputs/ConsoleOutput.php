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

        $js = $this->transformToJs($scores);
        $content = $requestHandled->response->getContent();

        // Try to put the widget at the end, directly before the </body>
        $pos = strripos($content, '</body>');
        if (false !== $pos) {
            $content = substr($content, 0, $pos).$js.substr($content, $pos);
        } else {
            $content = $content.$js;
        }

        // Update the new content and reset the content length
        $requestHandled->response->setContent($content);
        $requestHandled->response->headers->remove('Content-Length');
    }

    protected function shouldOutput($requestHandled): bool
    {
        return $this->isRequestHandledEvent($requestHandled) &&
               $this->isHtmlResponse($requestHandled->response);
    }

    protected function transformToJs(Collection $scores)
    {
        return $scores->pipe(function ($scores) {
            $js = $scores->reduce(function ($js, $score) {
                unset($score['Basic']);
                $score = str_replace('`', '\`', to_pretty_json($score));

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

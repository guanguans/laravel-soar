<?php

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelSoar\Outputs;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class JsonOutput extends Output
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

        $scores = $scores->map(function ($score) {
            unset($score['Basic']);

            return $score;
        });

        $data = Arr::wrap($requestHandled->response->getData(true)) and $data['soar_scores'] = $scores;
        // Update the new content and reset the content length
        $requestHandled->response->setData($data);
        $requestHandled->response->headers->remove('Content-Length');
    }

    protected function shouldOutput($requestHandled)
    {
        return $this->isRequestHandledEvent($requestHandled) &&
               $this->isJsonResponse($requestHandled->response);
    }
}

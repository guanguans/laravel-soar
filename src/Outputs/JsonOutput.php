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
     * @param \Symfony\Component\HttpFoundation\Response $response
     *
     * @return mixed
     */
    public function output(Collection $scores, $response)
    {
        if (! $this->shouldOutputInJsonResponse($response)) {
            return;
        }

        $scores = $scores->map(function ($score) {
            unset($score['Basic']);

            return $score;
        });

        $data = Arr::wrap($response->getData(true)) and $data['soar_scores'] = $scores;
        $response->setData($data);
    }
}

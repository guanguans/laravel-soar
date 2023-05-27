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
     * @var string
     */
    protected $key;

    public function __construct(string $key = 'soar_scores')
    {
        $this->key = $key;
    }

    public function output(Collection $scores, $dispatcher)
    {
        if (! $this->isJsonResponse($dispatcher)) {
            return;
        }

        $scores = $scores->map(function ($score) {
            unset($score['Basic']);

            return $score;
        });

        $data = Arr::wrap($dispatcher->getData(true)) and $data[$this->key] = $scores;
        // Update the new content and reset the content length
        $dispatcher->setData($data);
        $dispatcher->headers->remove('Content-Length');
    }
}

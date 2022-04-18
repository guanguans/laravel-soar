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

class DumpOutput extends Output
{
    /**
     * {@inheritdoc}
     */
    public function output(Collection $scores, $dispatcher)
    {
        $scores->each(function (array $score) {
            unset($score['Basic']);
            dump($score);
        });
    }
}

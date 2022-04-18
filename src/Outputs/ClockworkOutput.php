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

class ClockworkOutput extends Output
{
    /**
     * @param \Illuminate\Console\Events\CommandFinished        $event
     * @param \Illuminate\Foundation\Http\Events\RequestHandled $event
     *
     * @return mixed
     */
    public function output(Collection $scores, $event)
    {
        if (! $this->shouldOutput($event)) {
            return;
        }

        $scores->each(function (array $score) {
            unset($score['Basic']);
            clock()->warning($score['Summary'], $score);
        });
    }

    protected function shouldOutput($event): bool
    {
        return function_exists('clock');
    }
}

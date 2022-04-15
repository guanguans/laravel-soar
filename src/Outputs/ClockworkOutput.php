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
    public function output(Collection $scores, $operator)
    {
        if (! $this->shouldOutputInClockwork($operator)) {
            return;
        }

        $scores->each(function (array $score) {
            $summary = $score['Summary'];
            $level = $score['Basic']['Level'];
            unset($score['Summary'], $score['Basic']);
            clock()->{$level}($summary, $score);
        });
    }
}

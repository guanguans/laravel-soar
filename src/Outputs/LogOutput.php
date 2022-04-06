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
use Illuminate\Support\Facades\Log;

class LogOutput extends Output
{
    /**
     * @var string
     */
    protected $channel;

    public function __construct($channel = 'daily')
    {
        $this->channel = $channel;
    }

    /**
     * @param \Illuminate\Console\Events\CommandFinished        $event
     * @param \Illuminate\Foundation\Http\Events\RequestHandled $event
     *
     * @return mixed
     */
    public function output(Collection $scores, $event)
    {
        if ($this->shouldOutputInEvent($event)) {
            return;
        }

        $scores->each(function (array $score) {
            Log::channel($this->channel)
                ->log(
                    $score['Basic']['Level'],
                    $score['Summary'].PHP_EOL.var_output($score, true).PHP_EOL
                );
        });
    }
}

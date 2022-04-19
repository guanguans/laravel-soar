<?php

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelSoar\Events;

use Guanguans\LaravelSoar\Contracts\Output;
use Illuminate\Support\Collection;

class OutputtingEvent
{
    /**
     * @var \Guanguans\LaravelSoar\Contracts\Output
     */
    public $output;

    /**
     * @var \Illuminate\Support\Collection
     */
    public $scores;

    /**
     * @var \Illuminate\Console\Events\CommandFinished|\Symfony\Component\HttpFoundation\Response
     */
    public $dispatcher;

    /**
     * @param \Illuminate\Console\Events\CommandFinished|\Symfony\Component\HttpFoundation\Response $dispatcher
     */
    public function __construct(Output $output, Collection $scores, $dispatcher)
    {
        $this->output = $output;
        $this->scores = $scores;
        $this->dispatcher = $dispatcher;
    }
}

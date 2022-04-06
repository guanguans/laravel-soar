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
    protected $output;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $scores;

    /**
     * @var \Symfony\Component\HttpFoundation\Response
     * @var \Illuminate\Console\Events\CommandFinished
     * @var \Illuminate\Foundation\Http\Events\RequestHandled
     */
    protected $operator;

    /**
     * @param \Symfony\Component\HttpFoundation\Response        $operator
     * @param \Illuminate\Console\Events\CommandFinished        $operator
     * @param \Illuminate\Foundation\Http\Events\RequestHandled $operator
     */
    public function __construct(Output $output, Collection $scores, $operator)
    {
        $this->output = $output;
        $this->scores = $scores;
        $this->operator = $operator;
    }
}

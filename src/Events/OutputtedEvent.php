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

class OutputtedEvent
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
     * @var mixed
     */
    protected $result;

    /**
     * @param mixed $result
     */
    public function __construct(Output $output, Collection $scores, $result)
    {
        $this->output = $output;
        $this->scores = $scores;
        $this->result = $result;
    }
}

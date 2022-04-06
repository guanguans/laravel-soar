<?php

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelSoar;

use Guanguans\LaravelSoar\Contracts\Output;
use Guanguans\LaravelSoar\Events\OutputtedEvent;
use Guanguans\LaravelSoar\Events\OutputtingEvent;
use Guanguans\SoarPHP\Exceptions\InvalidArgumentException;
use Illuminate\Support\Collection;
use Illuminate\Support\Fluent;

class OutputManager extends Fluent implements Output
{
    /**
     * @param Output[] $outputs
     */
    public function __construct($outputs = [])
    {
        foreach ($outputs as $index => $output) {
            $this->offsetSet($index, $output);
        }

        parent::__construct($outputs);
    }

    public function offsetSet($offset, $value): void
    {
        if (! $value instanceof Output) {
            throw new InvalidArgumentException(sprintf('The $value must be instance of %s', Output::class));
        }

        $this->attributes[$offset] = $value;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Response        $operator
     * @param \Illuminate\Console\Events\CommandFinished        $operator
     * @param \Illuminate\Foundation\Http\Events\RequestHandled $operator
     *
     * @return mixed
     */
    public function output(Collection $scores, $operator)
    {
        /* @var Output $output */
        foreach ($this->attributes as $output) {
            event(new OutputtingEvent($output, $scores, $operator));
            $result = $output->output($scores, $operator);
            event(new OutputtedEvent($output, $scores, $result));
        }
    }
}

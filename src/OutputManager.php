<?php

declare(strict_types=1);

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
    public function __construct(array $outputs = [])
    {
        foreach ($outputs as $index => $output) {
            $this->offsetSet($index, $output);
        }
    }

    public function offsetSet($offset, $value): void
    {
        if (! $value instanceof Output) {
            throw new InvalidArgumentException(sprintf('The $value must be instance of %s', Output::class));
        }

        $this->attributes[$offset] = $value;
    }

    public function output(Collection $scores, $dispatcher): void
    {
        // @var Output $output
        foreach ($this->attributes as $output) {
            event(new OutputtingEvent($output, $scores, $dispatcher));
            $result = $output->output($scores, $dispatcher);
            event(new OutputtedEvent($output, $scores, $result));
        }
    }
}

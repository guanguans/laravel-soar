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
use Guanguans\LaravelSoar\Contracts\Sanitizer;
use Guanguans\LaravelSoar\Events\OutputtedEvent;
use Guanguans\LaravelSoar\Events\OutputtingEvent;
use Guanguans\LaravelSoar\Exceptions\BadMethodCallException;
use Guanguans\LaravelSoar\Exceptions\InvalidArgumentException;
use Illuminate\Support\Collection;
use Illuminate\Support\Fluent;

class OutputManager extends Fluent implements Output
{
    /**
     * @param array<\Guanguans\LaravelSoar\Contracts\Output> $outputs
     *
     * @noinspection MagicMethodsValidityInspection
     * @noinspection MissingParentCallInspection
     * @noinspection PhpMissingParentConstructorInspection
     */
    public function __construct(array $outputs = [])
    {
        foreach ($outputs as $index => $output) {
            $this->offsetSet($index, $output);
        }
    }

    /**
     * @noinspection MissingParentCallInspection
     *
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value): void
    {
        if (! $value instanceof Output) {
            throw new InvalidArgumentException(sprintf('The value must be instance of %s', Output::class));
        }

        $this->attributes[$offset] = $value;
    }

    public function output(Collection $scores, $dispatcher): void
    {
        /** @var \Guanguans\LaravelSoar\Contracts\Output $output */
        foreach ($this->attributes as $output) {
            if (! $output->shouldOutput($dispatcher)) {
                continue;
            }

            $output instanceof Sanitizer and $scores = $output->sanitize($scores);
            event(new OutputtingEvent($output, $scores, $dispatcher));
            $result = $output->output($scores, $dispatcher);
            event(new OutputtedEvent($output, $scores, $result));
        }
    }

    public function shouldOutput($dispatcher): bool
    {
        throw new BadMethodCallException(sprintf('The method [%s] is not implemented.', __METHOD__));
    }
}

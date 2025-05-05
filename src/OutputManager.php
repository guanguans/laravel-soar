<?php

declare(strict_types=1);

/**
 * Copyright (c) 2020-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-soar
 */

namespace Guanguans\LaravelSoar;

use Guanguans\LaravelSoar\Contracts\Output;
use Guanguans\LaravelSoar\Contracts\Sanitizer;
use Guanguans\LaravelSoar\Events\OutputtedEvent;
use Guanguans\LaravelSoar\Events\OutputtingEvent;
use Guanguans\LaravelSoar\Exceptions\InvalidArgumentException;
use Illuminate\Console\Events\CommandFinished;
use Illuminate\Support\Collection;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;

class OutputManager extends Fluent implements Output
{
    /**
     * @noinspection MagicMethodsValidityInspection
     * @noinspection MissingParentCallInspection
     * @noinspection PhpMissingParentConstructorInspection
     *
     * @param list<\Guanguans\LaravelSoar\Contracts\Output> $outputs
     */
    public function __construct(array $outputs = [])
    {
        foreach ($outputs as $index => $output) {
            $this->offsetSet($index, $output);
        }
    }

    public function shouldOutput($dispatcher): bool
    {
        $exclusions = config('soar.exclusions', []);

        if ($dispatcher instanceof CommandFinished) {
            return !Str::is($exclusions, $dispatcher->command);
        }

        return !request()->is($exclusions) && !request()->routeIs($exclusions);
    }

    public function output(Collection $scores, $dispatcher): void
    {
        if (!$this->shouldOutput($dispatcher)) {
            return;
        }

        /** @var \Guanguans\LaravelSoar\Contracts\Output $output */
        foreach ($this->attributes as $output) {
            if (!$output->shouldOutput($dispatcher)) {
                continue;
            }

            $output instanceof Sanitizer and $scores = $output->sanitize($scores);
            event(new OutputtingEvent($output, $scores, $dispatcher));
            $result = $output->output($scores, $dispatcher);
            event(new OutputtedEvent($output, $scores, $result));
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
        if (!$value instanceof Output) {
            throw new InvalidArgumentException(\sprintf('The value must be instance of %s', Output::class));
        }

        $this->attributes[$offset] = $value;
    }
}

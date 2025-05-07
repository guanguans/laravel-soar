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

use Guanguans\LaravelSoar\Contracts\OutputContract;
use Guanguans\LaravelSoar\Contracts\SanitizerContract;
use Guanguans\LaravelSoar\Events\OutputtedEvent;
use Guanguans\LaravelSoar\Events\OutputtingEvent;
use Illuminate\Console\Events\CommandFinished;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class OutputManager extends Fluent implements OutputContract
{
    public function shouldOutput(CommandFinished|Response $outputter): bool
    {
        $exclusions = config('soar.exclusions', []);

        if ($outputter instanceof CommandFinished) {
            return !Str::is($exclusions, $outputter->command);
        }

        return !Request::is($exclusions) && !Request::routeIs($exclusions);
    }

    public function output(Collection $scores, CommandFinished|Response $outputter): mixed
    {
        if (!$this->shouldOutput($outputter)) {
            return null;
        }

        foreach ($this->attributes as $output) {
            \assert($output instanceof OutputContract);

            if (!$output->shouldOutput($outputter)) {
                continue;
            }

            $output instanceof SanitizerContract and $scores = $output->sanitize($scores);
            event(new OutputtingEvent($output, $scores, $outputter));
            $result = $output->output($scores, $outputter);
            event(new OutputtedEvent($output, $scores, $outputter, $result));
        }

        return null;
    }
}

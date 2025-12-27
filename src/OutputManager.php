<?php

declare(strict_types=1);

/**
 * Copyright (c) 2020-2026 guanguans<ityaozm@gmail.com>
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
        $except = config('soar.except', []);

        if ($outputter instanceof CommandFinished) {
            return !Str::is($except, $outputter->command);
        }

        return !Request::is($except) && !Request::routeIs($except);
    }

    /**
     * @noinspection PhpUndefinedMethodInspection
     * @noinspection NullPointerExceptionInspection
     */
    public function output(Collection $scores, CommandFinished|Response $outputter): Collection
    {
        if (!$this->shouldOutput($outputter)) {
            return collect();
        }

        return collect($this->attributes)
            ->tap(fn () => event(new OutputtingEvent($this, $scores, $outputter)))
            ->reduce(
                static function (Collection $results, OutputContract $outputContract) use ($outputter, $scores): Collection {
                    if (!$outputContract->shouldOutput($outputter)) {
                        return $results;
                    }

                    if ($outputContract instanceof SanitizerContract) {
                        $scores = $outputContract->sanitize($scores);
                    }

                    return $results->put($outputContract::class, $outputContract->output($scores, $outputter));
                },
                collect()
            )
            ->tap(fn (Collection $results) => event(new OutputtedEvent($this, $scores, $outputter, $results)));
    }
}

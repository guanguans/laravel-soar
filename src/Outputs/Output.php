<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelSoar\Outputs;

use Guanguans\LaravelSoar\Contracts\Sanitizer;
use Guanguans\LaravelSoar\Outputs\Concerns\OutputCondition;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

abstract class Output implements \Guanguans\LaravelSoar\Contracts\Output, Sanitizer
{
    use OutputCondition;

    protected array $except = [];

    public function sanitize(Collection $scores): Collection
    {
        return $scores->map(fn (array $score): array => Arr::except($score, $this->except));
    }

    /**
     * @throws \JsonException
     */
    protected function hydrateScores(Collection $scores): string
    {
        return $scores->reduce(
            fn (string $carry, array $score): string => $carry.PHP_EOL.$this->hydrateScore($score),
            ''
        );
    }

    /**
     * @throws \JsonException
     */
    protected function hydrateScore(array $score): string
    {
        return $score['Summary'].PHP_EOL.to_pretty_json($score);
    }
}

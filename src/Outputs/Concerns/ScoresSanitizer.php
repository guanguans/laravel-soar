<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelSoar\Outputs\Concerns;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

trait ScoresSanitizer
{
    protected array $except = [];

    public function sanitize(Collection $scores): Collection
    {
        return $scores->map(fn (array $score): array => Arr::except($score, $this->except));
    }
}

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

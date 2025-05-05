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

namespace Guanguans\LaravelSoar\Outputs;

use Illuminate\Support\Collection;

class RayOutput extends Output
{
    public function __construct(protected string $label = 'Soar Scores') {}

    public function shouldOutput($dispatcher): bool
    {
        return \function_exists('ray');
    }

    public function output(Collection $scores, mixed $dispatcher): void
    {
        ray(...$scores)->label($this->label);
    }
}

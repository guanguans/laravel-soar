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

use Illuminate\Support\Collection;

class RayOutput extends Output
{
    protected string $label;

    public function __construct(string $label = 'Soar Scores')
    {
        $this->label = $label;
    }

    public function shouldOutput($dispatcher): bool
    {
        return \function_exists('ray');
    }

    /**
     * @psalm-suppress UndefinedDocblockClass
     *
     * @param mixed $dispatcher
     */
    public function output(Collection $scores, $dispatcher): void
    {
        ray(...$scores)->label($this->label);
    }
}

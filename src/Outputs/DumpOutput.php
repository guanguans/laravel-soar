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

class DumpOutput extends Output
{
    private bool $exit;

    public function __construct(bool $exit = false)
    {
        $this->exit = $exit;
    }

    public function output(Collection $scores, $dispatcher): void
    {
        $scores
            ->map(static function ($score): string {
                unset($score['Basic']);

                return to_pretty_json($score);
            })
            ->when($this->exit, static function (Collection $scores): void {
                $scores->dd();
            })
            ->dump();
    }
}

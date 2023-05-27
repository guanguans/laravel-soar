<?php

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
    /**
     * @var bool
     */
    private $exit;

    public function __construct(bool $exit = false)
    {
        $this->exit = $exit;
    }

    public function output(Collection $scores, $dispatcher)
    {
        $scores->map(function ($score) {
            unset($score['Basic']);

            return to_pretty_json($score);
        })->when($this->exit, function (Collection $scores) {
            $scores->dd();
        })->dump();
    }
}

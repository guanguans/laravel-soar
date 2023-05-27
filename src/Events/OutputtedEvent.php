<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelSoar\Events;

use Guanguans\LaravelSoar\Contracts\Output;
use Illuminate\Support\Collection;

class OutputtedEvent
{
    public Output $output;

    public Collection $scores;

    public $result;

    public function __construct(Output $output, Collection $scores, $result)
    {
        $this->output = $output;
        $this->scores = $scores;
        $this->result = $result;
    }
}

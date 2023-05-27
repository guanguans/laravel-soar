<?php

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelSoar\Outputs;

use Guanguans\LaravelSoar\Contracts\Output;
use Illuminate\Support\Collection;

class NullOutput implements Output
{
    public function output(Collection $scores, $event)
    {
        // noop
    }
}

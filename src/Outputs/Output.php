<?php

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelSoar\Outputs;

use Guanguans\LaravelSoar\Outputs\Concerns\OutputCondition;

abstract class Output implements \Guanguans\LaravelSoar\Contracts\Output
{
    use OutputCondition;
}

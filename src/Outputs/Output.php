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
use Guanguans\LaravelSoar\Outputs\Concerns\OutputConditions;
use Guanguans\LaravelSoar\Outputs\Concerns\ScoresHydrator;
use Guanguans\LaravelSoar\Outputs\Concerns\ScoresSanitizer;

abstract class Output implements \Guanguans\LaravelSoar\Contracts\Output, Sanitizer
{
    use OutputConditions;
    use ScoresHydrator;
    use ScoresSanitizer;

    public function shouldOutput($dispatcher): bool
    {
        return true;
    }
}

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

use Guanguans\LaravelSoar\Contracts\OutputContract;
use Guanguans\LaravelSoar\Contracts\SanitizerContract;
use Guanguans\LaravelSoar\Outputs\Concerns\OutputConditions;
use Guanguans\LaravelSoar\Outputs\Concerns\ScoresHydrator;
use Guanguans\LaravelSoar\Outputs\Concerns\ScoresSanitizer;
use Illuminate\Console\Events\CommandFinished;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractOutput implements OutputContract, SanitizerContract
{
    use OutputConditions;
    use ScoresHydrator;
    use ScoresSanitizer;

    public function shouldOutput(CommandFinished|Response $dispatcher): bool
    {
        return true;
    }
}

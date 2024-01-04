<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelSoar\Outputs\Concerns;

use Illuminate\Console\Events\CommandFinished;
use Illuminate\Support\Str;

/**
 * @mixin \Guanguans\LaravelSoar\Outputs\Output
 */
trait ShouldOutput
{
    protected array $exclusions = [];

    /**
     * @param \Illuminate\Console\Events\CommandFinished|\Symfony\Component\HttpFoundation\Response $dispatcher
     */
    public function shouldOutput($dispatcher): bool
    {
        if ($dispatcher instanceof CommandFinished) {
            return ! Str::is($this->exclusions, $dispatcher->command);
        }

        return ! request()->is($this->exclusions) && ! request()->routeIs($this->exclusions);
    }
}

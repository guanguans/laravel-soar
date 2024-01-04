<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelSoar\Contracts;

use Illuminate\Support\Collection;

interface Output
{
    /**
     * @param \Illuminate\Console\Events\CommandFinished|\Symfony\Component\HttpFoundation\Response $dispatcher
     */
    public function shouldOutput($dispatcher): bool;

    /**
     * @param \Illuminate\Console\Events\CommandFinished|\Symfony\Component\HttpFoundation\Response $dispatcher
     */
    public function output(Collection $scores, $dispatcher);
}

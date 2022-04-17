<?php

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
     * @param \Symfony\Component\HttpFoundation\Response        $requestHandled
     * @param \Illuminate\Console\Events\CommandFinished        $requestHandled
     * @param \Illuminate\Foundation\Http\Events\RequestHandled $requestHandled
     *
     * @return mixed
     */
    public function output(Collection $scores, $requestHandled);
}

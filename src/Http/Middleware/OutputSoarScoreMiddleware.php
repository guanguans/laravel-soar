<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelSoar\Http\Middleware;

use Guanguans\LaravelSoar\Bootstrapper;
use Guanguans\LaravelSoar\OutputManager;

class OutputSoarScoreMiddleware
{
    protected \Guanguans\LaravelSoar\Bootstrapper $bootstrapper;

    protected \Guanguans\LaravelSoar\OutputManager $outputManager;

    public function __construct(Bootstrapper $bootstrapper, OutputManager $outputManager)
    {
        $this->bootstrapper = $bootstrapper;
        $this->outputManager = $outputManager;
    }

    /**
     * Handle an incoming request.
     */
    public function handle(\Illuminate\Http\Request $request, \Closure $next)
    {
        /** @var \Illuminate\Http\Response $response */
        $response = $next($request);

        $this->outputManager->output($this->bootstrapper->getScores(), $response);

        return $response;
    }
}

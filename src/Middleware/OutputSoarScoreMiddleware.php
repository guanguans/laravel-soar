<?php

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelSoar\Middleware;

use Closure;
use Guanguans\LaravelSoar\Bootstrapper;
use Guanguans\LaravelSoar\OutputManager;

class OutputSoarScoreMiddleware
{
    /**
     * @var \Guanguans\LaravelSoar\Bootstrapper
     */
    protected $bootstrapper;

    /**
     * @var \Guanguans\LaravelSoar\OutputManager
     */
    protected $outputManager;

    public function __construct(Bootstrapper $bootstrapper, OutputManager $outputManager)
    {
        $this->bootstrapper = $bootstrapper;
        $this->outputManager = $outputManager;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /** @var \Illuminate\Http\Response $response */
        $response = $next($request);

        $this->outputManager->output($this->bootstrapper->getScores(), $response);

        return $response;
    }
}

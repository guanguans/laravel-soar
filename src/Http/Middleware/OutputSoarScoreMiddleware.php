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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OutputSoarScoreMiddleware
{
    protected Bootstrapper $bootstrapper;

    protected OutputManager $outputManager;

    public function __construct(Bootstrapper $bootstrapper, OutputManager $outputManager)
    {
        $this->bootstrapper = $bootstrapper;
        $this->outputManager = $outputManager;
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, callable $next): Response
    {
        return tap($next($request), function (Response $response): void {
            $this->outputManager->output($this->bootstrapper->getScores(), $response);
        });
    }
}

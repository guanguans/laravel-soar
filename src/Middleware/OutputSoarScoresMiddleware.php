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

namespace Guanguans\LaravelSoar\Middleware;

use Guanguans\LaravelSoar\Bootstrapper;
use Guanguans\LaravelSoar\OutputManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OutputSoarScoresMiddleware
{
    public function __construct(
        private Bootstrapper $bootstrapper,
        private OutputManager $outputManager
    ) {}

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, callable $next): Response
    {
        return tap($next($request), fn (Response $response): mixed => $this->outputManager->output(
            $this->bootstrapper->getScores(),
            $response
        ));
    }
}

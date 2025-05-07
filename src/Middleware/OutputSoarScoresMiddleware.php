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
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class OutputSoarScoresMiddleware
{
    public function __construct(
        private Bootstrapper $bootstrapper,
        private OutputManager $outputManager
    ) {}

    /**
     * @noinspection RedundantDocCommentTagInspection
     *
     * @param \Closure(\Illuminate\Http\Request): (JsonResponse|RedirectResponse|Response) $next
     *
     * @throws \JsonException
     */
    public function handle(Request $request, \Closure $next): SymfonyResponse
    {
        return tap(
            $next($request),
            fn (SymfonyResponse $symfonyResponse): mixed => $this->outputManager->output(
                $this->bootstrapper->getScores(),
                $symfonyResponse
            )
        );
    }
}

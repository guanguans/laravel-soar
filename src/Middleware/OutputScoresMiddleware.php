<?php

declare(strict_types=1);

/**
 * Copyright (c) 2020-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-soar
 */

namespace Guanguans\LaravelSoar\Middleware;

use Guanguans\LaravelSoar\Bootstrapper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class OutputScoresMiddleware
{
    public function __construct(private readonly Bootstrapper $bootstrapper) {}

    /**
     * @api
     *
     * @param \Closure(\Illuminate\Http\Request): (JsonResponse|RedirectResponse|Response) $next
     *
     * @noinspection RedundantDocCommentTagInspection
     */
    public function handle(Request $request, \Closure $next): SymfonyResponse
    {
        return tap(
            $next($request),
            fn (SymfonyResponse $symfonyResponse): Collection => $this->bootstrapper->outputScores($symfonyResponse)
        );
    }
}

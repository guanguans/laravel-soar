<?php

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelSoar\Outputs\Concerns;

use Illuminate\Console\Events\CommandFinished;
use Illuminate\Foundation\Http\Events\RequestHandled;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

trait OutputCondition
{
    /**
     * @param mixed $operator
     */
    protected function shouldOutputInEvent($operator): bool
    {
        return $operator instanceof CommandFinished
               || $operator instanceof RequestHandled;
    }

    /**
     * @param mixed $operator
     */
    protected function shouldOutputInCommandFinished($operator): bool
    {
        return $operator instanceof CommandFinished;
    }

    /**
     * @param mixed $operator
     */
    protected function shouldOutputInRequestHandled($operator): bool
    {
        return $operator instanceof RequestHandled;
    }

    /**
     * @param mixed $operator
     */
    protected function shouldOutputInJsonResponse($operator): bool
    {
        return $operator instanceof JsonResponse;
    }

    /**
     * @param mixed $operator
     */
    protected function shouldOutputInResponse($operator): bool
    {
        return $operator instanceof Response;
    }

    /**
     * @param mixed $operator
     */
    protected function shouldOutputInHtmlResponse($operator): bool
    {
        return $operator instanceof Response
               && ! $operator instanceof JsonResponse
               && Str::contains($operator->headers->get('Content-Type'), 'text/html');
    }

    protected function shouldOutputInDebugBar($operator): bool
    {
        return class_exists('Barryvdh\Debugbar\Facade')
               && \Barryvdh\Debugbar\Facade::isEnabled()
               && $operator instanceof Response;
    }
}

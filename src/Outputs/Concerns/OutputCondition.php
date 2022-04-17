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
     * @param mixed $event
     */
    protected function isEvent($event): bool
    {
        return $event instanceof CommandFinished ||
               $event instanceof RequestHandled;
    }

    /**
     * @param mixed $event
     */
    protected function isCommandFinishedEvent($event): bool
    {
        return $event instanceof CommandFinished;
    }

    /**
     * @param mixed $event
     */
    protected function isRequestHandledEvent($event): bool
    {
        return $event instanceof RequestHandled;
    }

    /**
     * @param mixed $response
     */
    protected function isResponse($response): bool
    {
        return $response instanceof Response;
    }

    /**
     * @param mixed $response
     */
    protected function isHtmlResponse($response): bool
    {
        return $response instanceof Response &&
               Str::contains($response->headers->get('Content-Type'), 'text/html') &&
               ! $this->isJsonResponse($response);
    }

    /**
     * @param mixed $response
     */
    protected function isJsonResponse($response): bool
    {
        return $response instanceof JsonResponse &&
               Str::contains($response->headers->get('Content-Type'), 'application/json') &&
               transform($response, function (JsonResponse $response) {
                   if ('' === ($content = $response->getContent())) {
                       return false;
                   }

                   json_decode($content);
                   if (json_last_error()) {
                       return false;
                   }

                   return true;
               });
    }
}

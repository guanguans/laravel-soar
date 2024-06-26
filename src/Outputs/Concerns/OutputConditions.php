<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelSoar\Outputs\Concerns;

use Illuminate\Console\Events\CommandFinished;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait OutputConditions
{
    /**
     * @param \Illuminate\Console\Events\CommandFinished|\Symfony\Component\HttpFoundation\Response $dispatcher
     */
    protected function isCommandFinished($dispatcher): bool
    {
        return $dispatcher instanceof CommandFinished;
    }

    /**
     * @param \Illuminate\Console\Events\CommandFinished|\Symfony\Component\HttpFoundation\Response $dispatcher
     */
    protected function isResponse($dispatcher): bool
    {
        return $dispatcher instanceof Response;
    }

    /**
     * @param \Illuminate\Console\Events\CommandFinished|\Symfony\Component\HttpFoundation\Response $dispatcher
     */
    protected function isHtmlResponse($dispatcher): bool
    {
        return $this->isResponse($dispatcher)
            && false !== $dispatcher->getContent()
            && Str::contains($dispatcher->headers->get('Content-Type'), 'text/html')
            && ! $this->isJsonResponse($dispatcher);
    }

    /**
     * @param \Illuminate\Console\Events\CommandFinished|\Symfony\Component\HttpFoundation\Response $dispatcher
     */
    protected function isJsonResponse($dispatcher): bool
    {
        return $dispatcher instanceof JsonResponse
            && false !== $dispatcher->getContent()
            && Str::contains($dispatcher->headers->get('Content-Type'), 'application/json')
            && transform($dispatcher, static function (JsonResponse $dispatcher): bool {
                if ('' === ($content = $dispatcher->getContent())) {
                    return false;
                }

                try {
                    json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                } catch (\JsonException $jsonException) {
                    return false;
                }

                return true;
            });
    }
}

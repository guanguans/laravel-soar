<?php

/** @noinspection MethodVisibilityInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2020-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-soar
 */

namespace Guanguans\LaravelSoar\Outputs\Concerns;

use Illuminate\Console\Events\CommandFinished;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait OutputConditions
{
    protected function isCommandFinished(CommandFinished|Response $outputter): bool
    {
        return $outputter instanceof CommandFinished;
    }

    protected function isHtmlResponse(CommandFinished|Response $outputter): bool
    {
        return $outputter instanceof Response
            && false !== $outputter->getContent()
            && str($outputter->headers->get('Content-Type'))->contains('text/html')
            && !$this->isJsonResponse($outputter);
    }

    protected function isJsonResponse(CommandFinished|Response $outputter): bool
    {
        return $outputter instanceof JsonResponse
            && false !== $outputter->getContent()
            && str($outputter->headers->get('Content-Type'))->contains('application/json')
            && transform($outputter, static function (JsonResponse $jsonResponse): bool {
                if ('' === ($content = $jsonResponse->getContent())) {
                    return false;
                }

                try {
                    json_decode($content, false, 512, \JSON_THROW_ON_ERROR);
                } catch (\JsonException) {
                    return false;
                }

                return true;
            });
    }
}

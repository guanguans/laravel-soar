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

namespace Guanguans\LaravelSoar\Outputs;

use Illuminate\Console\Events\CommandFinished;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class JsonOutput extends AbstractOutput
{
    public function __construct(private string $key = 'soar_scores') {}

    /**
     * @noinspection PhpMissingParentCallCommonInspection
     */
    public function shouldOutput(CommandFinished|Response $outputter): bool
    {
        return $this->isJsonResponse($outputter);
    }

    /**
     * @throws \JsonException
     */
    public function output(Collection $scores, CommandFinished|Response $outputter): JsonResponse
    {
        \assert($outputter instanceof JsonResponse);

        // $data = $outputter->getData(true);
        $data = json_decode($outputter->getContent(), true, 512, \JSON_THROW_ON_ERROR);
        Arr::set($data, $this->key, $scores);

        // Update the new content and reset the content length
        $outputter->setData($data);
        $outputter->headers->remove('Content-Length');

        return $outputter;
    }
}

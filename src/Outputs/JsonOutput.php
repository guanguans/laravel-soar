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

class JsonOutput extends Output
{
    public function __construct(protected string $key = 'soar_scores') {}

    public function shouldOutput(CommandFinished|Response $dispatcher): bool
    {
        return $this->isJsonResponse($dispatcher);
    }

    public function output(Collection $scores, CommandFinished|Response $dispatcher): mixed
    {
        \assert($dispatcher instanceof JsonResponse);

        // $data = Arr::wrap($dispatcher->getData(true));
        $data = Arr::wrap(json_decode($dispatcher->getContent(), true, 512, \JSON_THROW_ON_ERROR));
        Arr::set($data, $this->key, $scores);

        // Update the new content and reset the content length
        $dispatcher->setData($data);
        $dispatcher->headers->remove('Content-Length');

        return $dispatcher;
    }
}

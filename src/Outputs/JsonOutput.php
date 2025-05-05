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

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class JsonOutput extends Output
{
    protected string $key;

    public function __construct(string $key = 'soar_scores')
    {
        $this->key = $key;
    }

    public function shouldOutput($dispatcher): bool
    {
        return $this->isJsonResponse($dispatcher);
    }

    public function output(Collection $scores, $dispatcher): void
    {
        /** @var \Symfony\Component\HttpFoundation\JsonResponse $dispatcher */
        $data = Arr::wrap($dispatcher->getData(true));
        Arr::set($data, $this->key, $scores);

        // Update the new content and reset the content length
        $dispatcher->setData($data);
        $dispatcher->headers->remove('Content-Length');
    }
}

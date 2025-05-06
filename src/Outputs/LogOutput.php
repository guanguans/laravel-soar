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
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogOutput extends Output
{
    public function __construct(
        protected string $channel = 'daily',
        protected string $level = 'warning'
    ) {}

    /**
     * @throws \JsonException
     */
    public function output(Collection $scores, CommandFinished|Response $dispatcher): mixed
    {
        $scores->each(fn (array $score) => Log::channel($this->channel)->log(
            $this->level,
            $this->hydrateScore($score)
        ));

        return $dispatcher;
    }
}

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

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class LogOutput extends Output
{
    protected string $channel;
    protected string $level;

    public function __construct(string $channel = 'daily', string $level = 'warning')
    {
        $this->channel = $channel;
        $this->level = $level;
    }

    /**
     * @param mixed $dispatcher
     *
     * @throws \JsonException
     */
    public function output(Collection $scores, $dispatcher): void
    {
        $scores->each(fn (array $score) => Log::channel($this->channel)->log(
            $this->level,
            $this->hydrateScore($score)
        ));
    }
}

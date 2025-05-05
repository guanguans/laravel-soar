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

class SyslogOutput extends Output
{
    protected int $priority;

    public function __construct(int $priority = \LOG_WARNING)
    {
        $this->priority = $priority;
    }

    /**
     * @param mixed $dispatcher
     *
     * @throws \JsonException
     */
    public function output(Collection $scores, $dispatcher): void
    {
        syslog($this->priority, $this->hydrateScores($scores));
    }
}

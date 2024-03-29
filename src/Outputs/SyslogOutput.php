<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelSoar\Outputs;

use Illuminate\Support\Collection;

class SyslogOutput extends Output
{
    protected int $priority;

    public function __construct(int $priority = LOG_WARNING)
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

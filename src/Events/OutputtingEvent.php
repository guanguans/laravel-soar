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

namespace Guanguans\LaravelSoar\Events;

use Guanguans\LaravelSoar\Contracts\Output;
use Illuminate\Support\Collection;

class OutputtingEvent
{
    public Output $output;
    public Collection $scores;
    public \Illuminate\Console\Events\CommandFinished|\Symfony\Component\HttpFoundation\Response $dispatcher;

    public function __construct(Output $output, Collection $scores, \Illuminate\Console\Events\CommandFinished|\Symfony\Component\HttpFoundation\Response $dispatcher)
    {
        $this->output = $output;
        $this->scores = $scores;
        $this->dispatcher = $dispatcher;
    }
}

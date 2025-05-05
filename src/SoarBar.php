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

namespace Guanguans\LaravelSoar;

use DebugBar\DataCollector\MemoryCollector;
use DebugBar\DataCollector\MessagesCollector;
use DebugBar\DataCollector\PhpInfoCollector;
use DebugBar\DebugBar;

class SoarBar extends DebugBar
{
    /**
     * @throws \DebugBar\DebugBarException
     */
    public function __construct()
    {
        $this->addCollector(new MemoryCollector)
            ->addCollector(new PhpInfoCollector)
            // ->addCollector(new MessagesCollector('Scores'))
            ->jsRenderer = new JavascriptRenderer($this);
    }
}

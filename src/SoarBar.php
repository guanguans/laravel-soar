<?php

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelSoar;

use DebugBar\DataCollector\MemoryCollector;
use DebugBar\DataCollector\MessagesCollector;
use DebugBar\DataCollector\PhpInfoCollector;
use DebugBar\DataCollector\RequestDataCollector;
use DebugBar\DebugBar;

class SoarBar extends DebugBar
{
    public function __construct()
    {
        // $this->addCollector(new MessagesCollector('scores'));
        $this->addCollector(new MessagesCollector());
        $this->addCollector(new MemoryCollector());
        $this->addCollector(new PhpInfoCollector());
        // $this->addCollector(new RequestDataCollector());
        $this->jsRenderer = new JavascriptRenderer($this);
    }
}

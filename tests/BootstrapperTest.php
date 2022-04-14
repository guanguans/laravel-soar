<?php

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Tests;

use Guanguans\LaravelSoar\Bootstrapper;
use Illuminate\Support\Collection;
use Nyholm\NSA;

class BootstrapperTest extends TestCase
{
    /**
     * @var Bootstrapper
     */
    protected $bootstrapper;

    protected function setUp(): void
    {
        parent::setUp();
        $this->bootstrapper = $this->app->make(Bootstrapper::class);
    }

    public function testBoot()
    {
        $this->bootstrapper->boot($this->app);
        $this->assertTrue($this->bootstrapper->isBooted());
    }

    public function testIsEnabled()
    {
        $this->assertEquals($this->app['config']['soar.enabled'], $this->bootstrapper->isEnabled());
    }

    public function testGetScores()
    {
        $this->assertInstanceOf(Collection::class, $scores = $this->bootstrapper->getScores());
        $this->assertNotEmpty($scores);

        $scores->each(function ($score) {
            $this->assertArrayHasKey('Summary', $score);
            $this->assertArrayHasKey('HeuristicRules', $score);
            $this->assertArrayHasKey('IndexRules', $score);
            $this->assertArrayHasKey('Explain', $score);
            $this->assertArrayHasKey('Backtraces', $score);
            $this->assertArrayHasKey('Basic', $score);
        });
    }

    public function testTransformToHumanTime()
    {
        $humanTime = NSA::invokeMethod($this->bootstrapper, 'transformToHumanTime', 2345.43);
        $this->assertIsString($humanTime);
        $this->assertEquals('2.35s', $humanTime);
    }
}

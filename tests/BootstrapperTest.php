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
        $scores->dump();
        $this->assertTrue($scores->isNotEmpty());

        $scores->each(function ($score) {
            $this->assertArrayHasKey('Summary', $score);
            $this->assertArrayHasKey('HeuristicRules', $score);
            $this->assertArrayHasKey('IndexRules', $score);
            $this->assertArrayHasKey('Explain', $score);
            $this->assertArrayHasKey('Backtraces', $score);
            $this->assertArrayHasKey('Basic', $score);
            $this->assertGreaterThanOrEqual(0, $score['Basic']['Score']);
        });
    }

    public function testTransformToHumanTime()
    {
        $humanTime = NSA::invokeMethod($this->bootstrapper, 'transformToHumanTime', 2345.43);
        $this->assertIsString($humanTime);
        $this->assertEquals('2.35s', $humanTime);
    }

    public function testFormatExplain()
    {
        $explain = [[
            'Item' => 'EXP.000',
            'Severity' => 'L0',
            'Summary' => 'Explain信息',
            'Content' => '| id | select\\_type | table | partitions | type | possible_keys | key | key\\_len | ref | rows | filtered | scalability | Extra | |---|---|---|---|---|---|---|---|---|---|---|---|---| | 1 | SIMPLE | *users* | NULL | ALL | NULL | NULL | NULL | NULL | 1 | ☠️ **100.00%** | O(n) | NULL | ',
            'Case' => '### Explain信息解读 #### SelectType信息解读 * **SIMPLE**: 简单SELECT(不使用UNION或子查询等). #### Type信息解读 * **ALL**: 最坏的情况, 从头到尾全表扫描. ',
            'Position' => 0,
        ]];
        $formattedExplain = $this->bootstrapper->formatExplain($explain);
        $this->assertIsArray($formattedExplain);
        $this->assertIsArray($formattedExplain['Content']);
        $this->assertIsArray($formattedExplain['Case']);
    }
}

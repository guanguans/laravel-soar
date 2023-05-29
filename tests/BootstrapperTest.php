<?php

declare(strict_types=1);

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

beforeEach(function (): void {
    $this->bootstrapper = $this->app->make(Bootstrapper::class);
});

it('boot', function (): void {
    $this->bootstrapper->boot($this->app);
    expect($this->bootstrapper->isBooted())->toBeTrue();
});

it('is enabled', function (): void {
    $this->markTestSkipped(__METHOD__);
    expect($this->bootstrapper->isEnabled())->toBe($this->app['config']['soar.enabled']);
});

it('get scores', function (): void {
    expect($scores = $this->bootstrapper->getScores())->toBeInstanceOf(Collection::class);
    $scores->dump();
    expect($scores->isNotEmpty())->toBeTrue();

    $scores->each(function ($score): void {
        expect($score)->toHaveKey('Summary');
        expect($score)->toHaveKey('HeuristicRules');
        expect($score)->toHaveKey('IndexRules');
        expect($score)->toHaveKey('Explain');
        expect($score)->toHaveKey('Backtraces');
        expect($score)->toHaveKey('Basic');
        expect($score['Basic']['Score'])->toBeGreaterThanOrEqual(0);
    });
});

it('transform to human time', function (): void {
    $this->markTestSkipped(__METHOD__);
    $humanTime = NSA::invokeMethod($this->bootstrapper, 'transformToHumanTime', 2345.43);
    expect($humanTime)->toBeString();
    expect($humanTime)->toBe('2.35s');
});

it('format explain', function (): void {
    $formattedExplain = [];
    $this->markTestSkipped(__METHOD__);
    $explain = [[
        'Item' => 'EXP.000',
        'Severity' => 'L0',
        'Summary' => 'Explain信息',
        'Content' => '| id | select\\_type | table | partitions | type | possible_keys | key | key\\_len | ref | rows | filtered | scalability | Extra | |---|---|---|---|---|---|---|---|---|---|---|---|---| | 1 | SIMPLE | *users* | NULL | ALL | NULL | NULL | NULL | NULL | 1 | ☠️ **100.00%** | O(n) | NULL | ',
        'Case' => '### Explain信息解读 #### SelectType信息解读 * **SIMPLE**: 简单SELECT(不使用UNION或子查询等). #### Type信息解读 * **ALL**: 最坏的情况, 从头到尾全表扫描. ',
        'Position' => 0,
    ]];

    // $formattedExplain = $this->bootstrapper->sanitizeExplain($explain);
    expect($formattedExplain)->toBeArray();
    expect($formattedExplain['Content'])->toBeArray();
    expect($formattedExplain['Case'])->toBeArray();
});

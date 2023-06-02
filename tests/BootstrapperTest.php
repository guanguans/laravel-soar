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

beforeEach(function (): void {
    $this->bootstrapper = $this->app->make(Bootstrapper::class);
});

it('can return `bool` for `isBooted`', function (): void {
    expect($this->bootstrapper)->isBooted()->toBeBool();
});

it('can boot `soar score` for `boot`', function (): void {
    expect($this->bootstrapper)->boot()->toBeNull();
});

it('can get `scores` for `getScores`', function (): void {
    expect($this->bootstrapper->getScores())->toBeCollection();
});

it('can to `human time` for `toHumanTime`', function (): void {
    $toHumanTime = fn (float $milliseconds) => $this->toHumanTime($milliseconds);

    expect([
        $toHumanTime->call($this->bootstrapper, 0.1),
        $toHumanTime->call($this->bootstrapper, 100),
        $toHumanTime->call($this->bootstrapper, 10000),
    ])->each->toBeString()->toEndWith('s');
});

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
use Pest\Expectation;

beforeEach(function (): void {
    $this->bootstrapper = $this->app->make(Bootstrapper::class);
});

it('will return `bool` for `isBooted`', function (): void {
    expect($this->bootstrapper)
        ->isBooted()->toBeBool();
});

it('will boot `soar score` for `boot`', function (): void {
    expect($this->bootstrapper)
        ->boot()->toBeNull();
});

it('will get `scores` for `getScores`', function (): void {
    expect($this->bootstrapper->getScores())->toBeCollection()
        // ->toMatchObjectSnapshot()
        ->isNotEmpty()->toBeTrue();
});

it('will to `human time` for `toHumanTime`', function (): void {
    expect([0.1, 100, 10000])
        ->each(
            fn (Expectation $item) => expect(
                (fn () => $this->toHumanTime($item->value))->call($this->bootstrapper)
            )->toBeString()
        );
});

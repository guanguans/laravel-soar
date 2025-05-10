<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpPossiblePolymorphicInvocationInspection */
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection SqlResolve */
/** @noinspection StaticClosureCanBeUsedInspection */
declare(strict_types=1);

/**
 * Copyright (c) 2020-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-soar
 */

use Guanguans\LaravelSoar\Bootstrapper;

beforeEach(function (): void {
    $this->bootstrapper = $this->app->make(Bootstrapper::class);
});

it('can boot `soar score` for `boot`', function (): void {
    expect($this->bootstrapper)->boot()->toBeNull();
})->group(__DIR__, __FILE__);

it('can get `scores` for `getScores`', function (): void {
    expect($this->bootstrapper->getScores())->toBeCollection();
})->group(__DIR__, __FILE__);

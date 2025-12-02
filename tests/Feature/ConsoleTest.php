<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpPossiblePolymorphicInvocationInspection */
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpVoidFunctionResultUsedInspection */
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
use Illuminate\Support\Arr;

beforeEach(function (): void {
    resolve(Bootstrapper::class)->boot();

    $this->see = collect(Arr::first(Soar::arrayScores('select * from users')))
        ->except(['ID', 'Fingerprint'])
        ->keys()
        ->push('Summary', 'Basic', 'Backtraces')
        ->all();
});

it('can not output soar scores', function (): void {
    config()->set('soar.except', ['output:all']);

    $this->artisan('output:all')
        // ->expectsOutput(OutputManager::class)
        ->expectsOutputToContain(OutputManager::class)
        ->assertOk();
})->group(__DIR__, __FILE__);

it('can outputs console', function (): void {
    $this->artisan('output:all')
        // ->expectsOutput(OutputManager::class)
        ->expectsOutputToContain(OutputManager::class)
        ->assertOk();
})->group(__DIR__, __FILE__);

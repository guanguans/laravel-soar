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

use Guanguans\LaravelSoar\OutputManager;
use Guanguans\LaravelSoar\Outputs\JsonOutput;

beforeEach(function (): void {
    $this->see = [
        'Summary',
        'Basic',
        'HeuristicRules',
        'IndexRules',
        'Explain',
        'Backtraces',
    ];
});

it('can not output soar scores', function (): void {
    config()->set('soar.except', ['outputs']);

    $this->artisan('outputs')
        ->assertOk()
        ->expectsOutput(OutputManager::class);

    // $this->get('outputs')
    //     ->assertOk()
    //     // ->assertSee($this->see)
    //     ->assertSee(OutputManager::class);
})->group(__DIR__, __FILE__);

it('can outputs console', function (): void {
    $this->artisan('outputs')
        ->assertOk()
        ->expectsOutput(OutputManager::class);
})->group(__DIR__, __FILE__);

it('can outputs http', function (): void {
    $this->get('outputs')
        ->assertOk()
        // ->assertSee($this->see)
        ->assertSee(OutputManager::class);
})->group(__DIR__, __FILE__);

it('can output to json', function (): void {
    $this->getJson('json')
        // ->dd()
        ->assertOk()
        // ->assertSee($this->see)
        ->assertSee(class_basename(JsonOutput::class));
})->group(__DIR__, __FILE__);

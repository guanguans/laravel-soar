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
use Guanguans\LaravelSoar\Facades\Soar;
use Guanguans\LaravelSoar\OutputManager;
use Guanguans\LaravelSoar\Outputs\JsonOutput;
use Illuminate\Support\Arr;

beforeEach(function (): void {
    resolve(Bootstrapper::class)->boot();

    $this->see = collect(Arr::first(Soar::arrayScores('select * from users')))
        ->except(['ID', 'Fingerprint'])
        ->keys()
        ->push('Summary', 'Basic', 'Backtraces')
        ->all();
});

it('can output to all', function (): void {
    $this
        ->get('output-all')
        ->assertOk()
        ->assertSee($this->see)
        ->assertSee(OutputManager::class);
})->group(__DIR__, __FILE__);

it('can output to json', function (): void {
    $this
        ->getJson('output-json')
        ->assertOk()
        ->assertJsonStructure()
        ->assertSee($this->see)
        ->assertSee(class_basename(JsonOutput::class));
})->group(__DIR__, __FILE__);

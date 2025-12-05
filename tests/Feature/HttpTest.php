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
use Illuminate\Support\Arr;
use Workbench\App\Support\Utils;

beforeEach(function (): void {
    resolve(Bootstrapper::class)->boot();

    $this->see = collect(Arr::first(Soar::arrayScores('select * from users')))
        ->except(['ID', 'Fingerprint'])
        ->keys()
        ->push('Summary', 'Basic', 'Backtraces')
        ->all();
});

it('is a general not output example', function (): void {
    config()->set('soar.except', ['general-example']);

    $this
        ->get('general-example')
        ->assertOk()
        ->assertDontSee($this->see)
        ->assertSee(Utils::GENERAL_OUTPUT_PHRASE);
})->group(__DIR__, __FILE__);

it('is a general output example', function (): void {
    $this
        ->get('general-example')
        ->assertOk()
        ->assertSee($this->see)
        ->assertSee(Utils::GENERAL_OUTPUT_PHRASE);
})->group(__DIR__, __FILE__);

it('is a json output example', function (): void {
    $this
        ->getJson('json-example')
        ->assertOk()
        ->assertJsonStructure()
        ->assertSee($this->see)
        ->assertSee(Utils::JSON_OUTPUT_PHRASE);
})->group(__DIR__, __FILE__);

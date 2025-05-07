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

use function Guanguans\LaravelSoar\Support\env_explode;
use function Guanguans\LaravelSoar\Support\humanly_milliseconds;
use function Guanguans\LaravelSoar\Support\json_pretty_encode;
use function Guanguans\LaravelSoar\Support\make;
use function Guanguans\LaravelSoar\Support\star_for;

it('can humanly milliseconds', function (): void {
    expect([
        humanly_milliseconds(0.1),
        humanly_milliseconds(100),
        humanly_milliseconds(10000),
        humanly_milliseconds(100000),
    ])->each->toBeString()->toEndWith('s');
})->group(__DIR__, __FILE__);

it('can explode env', function (): void {
    expect([
        env_explode('ENV_EXPLODE_STRING'),
        env_explode('ENV_EXPLODE_EMPTY'),
        env_explode('ENV_EXPLODE_NOT_EXIST'),
        // env_explode('ENV_EXPLODE_FALSE'),
        // env_explode('ENV_EXPLODE_NULL'),
        // env_explode('ENV_EXPLODE_TRUE'),
    ])->sequence(
        static fn (Expectation $expectation): Expectation => $expectation->toBeArray()->toBeTruthy(),
        static fn (Expectation $expectation): Expectation => $expectation->toBeArray()->toBeFalsy(),
        static fn (Expectation $expectation): Expectation => $expectation->toBeNull(),
        // static fn (Pest\Expectation $expectation): Pest\Expectation => $expectation->toBeFalse(),
        // static fn (Pest\Expectation $expectation): Pest\Expectation => $expectation->toBeNull(),
        // static fn (Pest\Expectation $expectation): Pest\Expectation => $expectation->toBeTrue(),
    );
})->group(__DIR__, __FILE__)->skip();

it('can json pretty encode', function (): void {
    expect(json_pretty_encode([1, 2, 3]))->toMatchJsonSnapshot();
})->group(__DIR__, __FILE__);

it('will throw `InvalidArgumentException` when abstract is empty array', function (): void {
    make([]);
})->group(__DIR__, __FILE__)->throws(InvalidArgumentException::class);

it('can return star for score', function (): void {
    expect([
        star_for(0),
        star_for(50),
        star_for(100),
    ])->sequence(
        '☆☆☆☆☆',
        '★★★☆☆',
        '★★★★★'
    );
})->group(__DIR__, __FILE__);

<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpPossiblePolymorphicInvocationInspection */
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection SqlResolve */
/** @noinspection StaticClosureCanBeUsedInspection */
/** @noinspection LaravelFunctionsInspection */
/** @noinspection PhpInternalEntityUsedInspection */
declare(strict_types=1);

/**
 * Copyright (c) 2020-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-soar
 */

use Illuminate\Support\Collection;
use Pest\Expectation;
use function Guanguans\LaravelSoar\Support\classes;
use function Guanguans\LaravelSoar\Support\env_explode;
use function Guanguans\LaravelSoar\Support\humanly_milliseconds;
use function Guanguans\LaravelSoar\Support\json_pretty_encode;

it('can get classes', function (): void {
    expect(
        classes(fn (string $file, string $class): bool => str($class)->startsWith('Rector'))
    )->toBeInstanceOf(Collection::class);
})->group(__DIR__, __FILE__);

it('can explode env', function (): void {
    expect([
        'APP_',
        'APP_DEBUG',
        'APP_NAME',
        'REDIS_PORT',
    ])->each(static function (Expectation $expectation): void {
        $env = env($expectation->value);
        $explodedEnv = env_explode($expectation->value);

        \is_string($env)
            ? expect($explodedEnv)->toBe(explode(',', $env))
            : expect($explodedEnv)->toBe($env);
    });
})->group(__DIR__, __FILE__);

it('can humanly milliseconds', function (): void {
    expect([
        humanly_milliseconds(0.1),
        humanly_milliseconds(100),
        humanly_milliseconds(10000),
        humanly_milliseconds(100000),
    ])->each->toBeString()->toEndWith('s');
})->group(__DIR__, __FILE__);

it('can json pretty encode', function (): void {
    expect(json_pretty_encode([1, 2, 3]))->toMatchJsonSnapshot();
})->group(__DIR__, __FILE__);

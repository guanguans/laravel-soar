<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpPossiblePolymorphicInvocationInspection */
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpVoidFunctionResultUsedInspection */
/** @noinspection SqlResolve */
/** @noinspection StaticClosureCanBeUsedInspection */
/** @noinspection LaravelFunctionsInspection */
declare(strict_types=1);

/**
 * Copyright (c) 2020-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-soar
 */

use Pest\Expectation;
use function Guanguans\LaravelSoar\Support\env_explode;
use function Guanguans\LaravelSoar\Support\human_milliseconds;
use function Guanguans\LaravelSoar\Support\json_pretty_encode;

it('can explode env', function (): void {
    putenv('APP_DEBUG=false');
    putenv('APP_NAME=Laravel Soar');
    putenv('REDIS_PORT=6379');

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

it('can human milliseconds', function (): void {
    expect([
        human_milliseconds(0.1),
        human_milliseconds(100),
        human_milliseconds(10000),
        human_milliseconds(100000),
    ])->each->toBeString()->toEndWith('s');
})->group(__DIR__, __FILE__);

it('can json pretty encode', function (): void {
    expect(json_pretty_encode([1, 2, 3]))->toMatchSnapshot();
})->group(__DIR__, __FILE__);

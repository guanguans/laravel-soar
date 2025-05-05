<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpPossiblePolymorphicInvocationInspection */
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUnhandledExceptionInspection */
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

namespace Guanguans\LaravelSoarTests\Macros;

use Guanguans\LaravelSoarTests\Models\User;

it('can return raw sql for `toRawSql`', function (): void {
    expect(User::query()->where('id', 1)->toRawSql())
        ->toBe('select * from "users" where "id" = 1');
})->group(__DIR__, __FILE__);

it('can dump raw sql for `dumpRawSql`', function (): void {
    expect(User::query()->where('id', 1)->dumpRawSql())->toBeString();
})->group(__DIR__, __FILE__);

it('can return soar array scores for `toSoarArrayScores`', function (): void {
    expect(User::query()->where('id', 1)->toSoarArrayScores())->toBeArray();
})->group(__DIR__, __FILE__);

it('can dump soar array scores for `dumpSoarArrayScores`', function (): void {
    expect(User::query()->where('id', 1)->dumpSoarArrayScores())->toBeArray();
})->group(__DIR__, __FILE__);

it('can return soar json scores for `toSoarJsonScores`', function (): void {
    expect(User::query()->where('id', 1)->toSoarJsonScores())->toBeJson();
})->group(__DIR__, __FILE__);

it('can dump soar json scores for `dumpSoarJsonScores`', function (): void {
    expect(User::query()->where('id', 1)->dumpSoarJsonScores())->toBeJson();
})->group(__DIR__, __FILE__);

it('can return soar html scores for `toSoarHtmlScores`', function (): void {
    expect(User::query()->where('id', 1)->toSoarHtmlScores())
        ->toBeString()->toContain('<head>', '<body onload=load()>', '<script>');
})->group(__DIR__, __FILE__);

it('can echo soar html scores for `echoSoarHtmlScores`', function (): void {
    expect(User::query()->where('id', 1)->echoSoarHtmlScores())->toBeNull();
})->group(__DIR__, __FILE__);

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

use Illuminate\Database\Eloquent\Builder;
use Workbench\App\Models\User;

it('can return raw sql for `toRawSql`', function (): void {
    expect(User::query()->where('id', 1)->where('name', 'soar')->toRawSql())->toBe(
        'select * from "users" where "id" = 1 and "name" = \'soar\''
    );
})->group(__DIR__, __FILE__);

it('can dump raw sql for `dumpRawSql`', function (): void {
    expect(User::query()->where('id', 1)->where('name', 'soar')->dumpRawSql())->toBeInstanceOf(Builder::class);
})->group(__DIR__, __FILE__);

it('can return soar array scores for `toSoarArrayScores`', function (): void {
    expect(User::query()->where('id', 1)->where('name', 'soar')->toSoarArrayScores())->toBeArray();
})->group(__DIR__, __FILE__);

it('can dump soar array scores for `dumpSoarArrayScores`', function (): void {
    expect(User::query()->where('id', 1)->where('name', 'soar')->dumpSoarArrayScores())->toBeInstanceOf(Builder::class);
})->group(__DIR__, __FILE__);

it('can return soar html scores for `toSoarHtmlScores`', function (): void {
    expect(User::query()->where('id', 1)->where('name', 'soar')->toSoarHtmlScores())->toBeString()->toContain(
        '<head>',
        '<body onload=load()>',
        '<script>'
    );
})->group(__DIR__, __FILE__);

it('can echo soar html scores for `echoSoarHtmlScores`', function (): void {
    expect(User::query()->where('id', 1)->where('name', 'soar')->echoSoarHtmlScores())->toBeInstanceOf(Builder::class);
})->group(__DIR__, __FILE__);

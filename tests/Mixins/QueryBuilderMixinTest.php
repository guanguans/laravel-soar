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
use Illuminate\Support\Facades\DB;
use Workbench\App\Models\User;

it('can return raw sql for `toRawSql`', function (): void {
    expect([
        User::query()->where('id', 1)->where('name', 'soar')->toRawSql(),
        DB::table('users')->where('id', 1)->where('name', 'soar')->toRawSql(),
    ])->each->toBe('select * from "users" where "id" = 1 and "name" = \'soar\'');
})->group(__DIR__, __FILE__);

it('can return quoted raw sql for `toRawSql`', function (): void {
    expect(User::query())
        ->whereIn('name', $names = [
            "O'Reilly",
            'He said "Hello"',
            'C:\\Users\\Admin',
            '100%',
            'user_name',
            '`backtick`',
            '$dollar$',
            "line1\nline2",
            'comma,semicolon;',
            '特殊字符：★☆！@#',
            null,
            111100,
            1.11100,
            false,
            true,
        ])
        ->toRawSql()
        ->toBe(
            $rawSql = <<<'SQL'
                select * from "users" where "name" in ('O''Reilly', 'He said "Hello"', 'C:\Users\Admin', '100%', 'user_name', '`backtick`', '$dollar$', 'line1
                line2', 'comma,semicolon;', '特殊字符：★☆！@#', NULL, 111100, 1.111, 0, 1)
                SQL
        );

    User::query()->whereIn('name', $names)->first();
    DB::scalar($rawSql);
})->group(__DIR__, __FILE__);

it('can dump raw sql for `dumpRawSql`', function (): void {
    expect(User::query()->where('id', 1)->where('name', 'soar')->dumpRawSql())->toBeInstanceOf(Builder::class);
})->group(__DIR__, __FILE__);

it('can return soar score for `toSoarScore`', function (): void {
    expect(User::query()->where('id', 1)->where('name', 'soar')->toSoarScore())->toBeArray();
})->group(__DIR__, __FILE__);

it('can dump soar score for `dumpSoarScore`', function (): void {
    expect(User::query()->where('id', 1)->where('name', 'soar')->dumpSoarScore())->toBeInstanceOf(Builder::class);
})->group(__DIR__, __FILE__);

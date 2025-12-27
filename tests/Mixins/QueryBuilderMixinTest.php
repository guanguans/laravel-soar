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
 * Copyright (c) 2020-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-soar
 */

use Illuminate\Database\Eloquent\Builder;
use Workbench\App\Models\User;

it('can return soar score for `toSoarScore`', function (): void {
    expect(User::query()->where('id', 1)->where('name', 'soar')->toSoarScore())->toBeArray();
})->group(__DIR__, __FILE__);

it('can dump soar score for `dumpSoarScore`', function (): void {
    expect(User::query()->where('id', 1)->where('name', 'soar')->dumpSoarScore())->toBeInstanceOf(Builder::class);
})->group(__DIR__, __FILE__);

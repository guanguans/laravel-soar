<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Tests\Macros;

use Tests\Models\User;

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

it('can dump soar array scores for `dumpSoarArrayScore`', function (): void {
    expect(User::query()->where('id', 1)->dumpSoarArrayScores())->toBeArray();
})->group(__DIR__, __FILE__);

it('can return soar json scores for `toSoarJsonScore`', function (): void {
    expect(User::query()->where('id', 1)->toSoarJsonScores())->toBeJson();
})->group(__DIR__, __FILE__);

it('can dump soar json scores for `dumpSoarJsonScores`', function (): void {
    expect(User::query()->where('id', 1)->dumpSoarJsonScores())->toBeJson();
})->group(__DIR__, __FILE__);

it('can return soar html scores for `toSoarHtmlScores`', function (): void {
    expect(User::query()->where('id', 1)->toSoarHtmlScores())
        ->toBeString()->toContain('<head>', '<body onload=load()>', '<script>');
})->group(__DIR__, __FILE__);

it('can echo soar html scores for `toSoarHtmlScores`', function (): void {
    expect(User::query()->where('id', 1)->echoSoarHtmlScores())->toBeNull();
})->group(__DIR__, __FILE__);

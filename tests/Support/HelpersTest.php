<?php

declare(strict_types=1);

/**
 * Copyright (c) 2020-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-soar
 */

namespace Tests\Support;

it('can echo variable for `var_output`', function (): void {
    expect(var_output([['arr']]))->toBeNull();
})->group(__DIR__, __FILE__);

it('can return variable for `var_output`', function (): void {
    expect(var_output([['arr'], new \stdClass], true))->toMatchTextSnapshot();
})->group(__DIR__, __FILE__);

it('can reduce array with key for `array_reduce_with_keys`', function (): void {
    expect(
        array_reduce_with_keys(
            ['a' => 1, 'b' => 2, 'c' => 3],
            static fn ($carry, $val, $key): string => $carry.$key,
            ''
        )
    )->toBe('abc');
})->group(__DIR__, __FILE__);

it('can return star for `to_star`', function (): void {
    expect([
        to_star(0),
        to_star(50),
        to_star(100),
    ])->sequence(
        '☆☆☆☆☆',
        '★★★☆☆',
        '★★★★★'
    );
})->group(__DIR__, __FILE__);

it('can to `human time` for `to_human_time`', function (): void {
    expect([
        to_human_time(0.1),
        to_human_time(100),
        to_human_time(10000),
    ])->each->toBeString()->toEndWith('s');
})->group(__DIR__, __FILE__);

it('can return pretty json for `to_pretty_json`', function (): void {
    expect(to_pretty_json([1, 2, 3]))->toMatchJsonSnapshot();
})->group(__DIR__, __FILE__);

it('can base64 encode file for `base64_encode_file`', function (): void {
    expect(base64_decode(base64_encode_file(__FILE__), true))->toBe(file_get_contents(__FILE__));
})->group(__DIR__, __FILE__);

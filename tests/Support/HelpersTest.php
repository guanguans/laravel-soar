<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Tests\Support;

it('echo variable code string for `var_output`', function (): void {
    expect(var_output([['arr']]))->toBeNull();
})->group(__DIR__, __FILE__);

it('return variable code string for `var_output`', function (): void {
    expect(var_output([['arr'], new \stdClass()], true))->toMatchTextSnapshot();
})->group(__DIR__, __FILE__);

it('reduce array with key for `array_reduce_with_key`', function (): void {
    expect(
        array_reduce_with_key(
            ['a' => 1, 'b' => 2, 'c' => 3],
            static fn ($carry, $val, $key): string => $carry.$key,
            ''
        )
    )
        ->toBe('abc');
})->group(__DIR__, __FILE__);

it('return star for `to_star`', function (): void {
    expect(to_star(100))->toBe('★★★★★')
        ->and(to_star(50))->toBe('★★★☆☆')
        ->and(to_star(0))->toBe('☆☆☆☆☆');
})->group(__DIR__, __FILE__);

it('return pretty json for `to_pretty_json`', function (): void {
    expect(to_pretty_json([1, 2, 3]))->toMatchJsonSnapshot();
})->group(__DIR__, __FILE__);

it('check is lumen environment for `is_lumen`', function (): void {
    expect(is_lumen())->toBeFalse();
})->group(__DIR__, __FILE__);

it('base64 encode file for `base64_encode_file`', function (): void {
    expect(base64_decode(base64_encode_file(__FILE__), true))->toBe(file_get_contents(__FILE__));
})->group(__DIR__, __FILE__);

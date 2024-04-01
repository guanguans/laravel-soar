<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Tests;

use Guanguans\LaravelSoar\Facades\Soar;

it('can add macro method', function (): void {
    Soar::macro('foo', function (): void {});

    /** @noinspection PhpUndefinedMethodInspection */
    expect(Soar::foo())->toBeNull();
})->group(__DIR__, __FILE__);

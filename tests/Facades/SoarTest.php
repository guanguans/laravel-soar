<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Tests\Facades;

use Guanguans\LaravelSoar\Facades\Soar;

it('can return soar version for `version`', function (): void {
    expect(Soar::version())->toBeString();
})->group(__DIR__, __FILE__);

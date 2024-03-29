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

use Guanguans\LaravelSoar\Exceptions\InvalidArgumentException;
use Guanguans\LaravelSoar\OutputManager;

it('can throw `InvalidArgumentException` for `offsetSet`', function (): void {
    /** @noinspection PhpParamsInspection */
    new OutputManager([new \stdClass()]);
})->group(__DIR__, __FILE__)->throws(InvalidArgumentException::class);

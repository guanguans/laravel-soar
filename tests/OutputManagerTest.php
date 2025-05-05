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

namespace Guanguans\LaravelSoarTests;

use Guanguans\LaravelSoar\Exceptions\InvalidArgumentException;
use Guanguans\LaravelSoar\OutputManager;

it('can throw `InvalidArgumentException` for `offsetSet`', function (): void {
    /** @noinspection PhpParamsInspection */
    new OutputManager([new \stdClass]);
})->group(__DIR__, __FILE__)->throws(InvalidArgumentException::class);

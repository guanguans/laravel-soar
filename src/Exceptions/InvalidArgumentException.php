<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelSoar\Exceptions;

use Guanguans\LaravelSoar\Contracts\Throwable;

class InvalidArgumentException extends \InvalidArgumentException implements Throwable
{
}

<?php

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelSoar\Facades;

use Guanguans\LaravelSoar\Soar as Accessor;

class Soar extends \Illuminate\Support\Facades\Facade
{
    public static function getFacadeAccessor()
    {
        return Accessor::class;
    }
}

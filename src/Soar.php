<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelSoar;

use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Traits\Tappable;

class Soar extends \Guanguans\SoarPHP\Soar
{
    // use Conditionable;
    use Macroable {
        Macroable::__call as macroCall;
    }
    use Tappable;

    /**
     * Handle dynamic method calls into the method.
     *
     * @return mixed
     */
    public function __call(string $method, array $parameters)
    {
        if (static::hasMacro($method)) {
            return $this->macroCall($method, $parameters);
        }

        return parent::__call($method, $parameters);
    }
}

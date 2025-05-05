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
    public function __call(string $method, array $parameters):mixed
    {
        if (static::hasMacro($method)) {
            return $this->macroCall($method, $parameters);
        }

        return parent::__call($method, $parameters);
    }
}

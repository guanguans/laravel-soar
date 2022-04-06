<?php

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelSoar\Facades;

/**
 * @method static getSoarPath()
 * @method static setSoarPath(string $soarPath)
 * @method static getOptions()
 * @method static setOption(string $key, $value)
 * @method static setOptions(array $options)
 * @method static score(string $sql)
 * @method static jsonScore(string $sql)
 * @method static arrayScore(string $sql)
 * @method static htmlScore(string $sql)
 * @method static mdScore(string $sql)
 * @method static exec(string $command)
 * @method static explain(string $sql)
 * @method static mdExplain(string $sql)
 * @method static htmlExplain(string $sql)
 * @method static syntaxCheck(string $sql)
 * @method static fingerPrint(string $sql)
 * @method static pretty(string $sql)
 * @method static md2html(string $sql)
 * @method static help()
 *
 * @see \Guanguans\SoarPHP\Soar
 */
class Soar extends \Illuminate\Support\Facades\Facade
{
    public static function getFacadeAccessor()
    {
        return 'soar';
    }
}

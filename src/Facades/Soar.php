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

/**
 * @method static getSoarPath()
 * @method static setSoarPath(string $soarPath)
 * @method static getPdoConfig()
 * @method static setPdoConfig(array $pdoConfig)
 * @method static getPdo()
 * @method static getExplainService(\PDO $pdo)
 * @method static getConfig()
 * @method static setConfig($key, $value = null)
 * @method static formatConfig(array $configs)
 * @method static score(string $sql)
 * @method static exec(string $command)
 * @method static explain(string $sql, string $format)
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
        return Accessor::class;
    }
}

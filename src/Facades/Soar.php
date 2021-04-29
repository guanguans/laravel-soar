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
 * @method static string getSoarPath()
 * @method static \Guanguans\SoarPHP\Soar setSoarPath(string $soarPath)
 * @method static array getPdoConfig()
 * @method static \Guanguans\SoarPHP\Soar setPdoConfig(array $pdoConfig)
 * @method static \PDO getPdo()
 * @method static \Guanguans\SoarPHP\Services\ExplainService getExplainService(\PDO $pdo)
 * @method static array getConfig()
 * @method static \Guanguans\SoarPHP\Soar setConfig(array $config)
 * @method static string getFormatConfig(array $configs)
 * @method static string score(string $sql)
 * @method static string explain(string $sql, string $format)
 * @method static string mdExplain(string $sql)
 * @method static string htmlExplain(string $sql)
 * @method static string syntaxCheck(string $sql)
 * @method static string fingerPrint(string $sql)
 * @method static string pretty(string $sql)
 * @method static string md2html(string $sql)
 * @method static string help()
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

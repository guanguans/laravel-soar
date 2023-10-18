<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelSoar\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Guanguans\SoarPHP\Soar create(array $options = [], null|string $soarPath = null)
 * @method static string help()
 * @method static string version()
 * @method static \Guanguans\SoarPHP\Soar clone()
 * @method static array arrayScores(array|string $sqls, int $depth = 512, int $options = 0)
 * @method static string jsonScores(array|string $sqls)
 * @method static string htmlScores(array|string $sqls)
 * @method static string markdownScores(array|string $sqls)
 * @method static string scores(array|string $sqls)
 * @method static \Guanguans\SoarPHP\Soar addOptions(array $options)
 * @method static \Guanguans\SoarPHP\Soar addOption(string $key, void $value)
 * @method static \Guanguans\SoarPHP\Soar removeOptions(array $keys)
 * @method static \Guanguans\SoarPHP\Soar removeOption(string $key)
 * @method static \Guanguans\SoarPHP\Soar onlyOptions(array $keys)
 * @method static \Guanguans\SoarPHP\Soar onlyOption(string $key)
 * @method static \Guanguans\SoarPHP\Soar onlyDsn()
 * @method static \Guanguans\SoarPHP\Soar setOptions(array $options)
 * @method static \Guanguans\SoarPHP\Soar setOption(string $key, void $value)
 * @method static \Guanguans\SoarPHP\Soar mergeOptions(array $options)
 * @method static \Guanguans\SoarPHP\Soar mergeOption(string $key, void $value)
 * @method static array getOptions()
 * @method static void getOption(string $key, void $default = null)
 * @method static string getSoarPath()
 * @method static \Guanguans\SoarPHP\Soar setSoarPath(string $soarPath)
 * @method static string|null getSudoPassword()
 * @method static \Guanguans\SoarPHP\Soar setSudoPassword(null|string $sudoPassword)
 * @method static void dd(void ...$args)
 * @method static \Guanguans\SoarPHP\Soar dump(void ...$args)
 * @method static string run(array|string $withOptions = [], null|callable $processTapper = null, null|callable $callback = null)
 * @method static \Guanguans\LaravelSoar\Soar|\Illuminate\Support\HigherOrderTapProxy tap(null|callable $callback = null)
 *
 * @see \Guanguans\LaravelSoar\Soar
 *
 * @mixin \Guanguans\LaravelSoar\Soar
 */
class Soar extends Facade
{
    /**
     * @noinspection MissingParentCallInspection
     */
    protected static function getFacadeAccessor(): string
    {
        return \Guanguans\LaravelSoar\Soar::class;
    }
}

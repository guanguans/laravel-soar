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

namespace Guanguans\LaravelSoar\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Guanguans\SoarPHP\Soar addOption(string $key, void $value)
 * @method static \Guanguans\SoarPHP\Soar addOptions(array $options)
 * @method static array arrayScores(array|string $sqls, int $depth = 512, int $options = 0)
 * @method static \Guanguans\SoarPHP\Soar clone()
 * @method static \Guanguans\SoarPHP\Soar create(array $options = [], string|null $soarBinary = null)
 * @method static void dd(void ...$args)
 * @method static \Guanguans\SoarPHP\Soar dump(void ...$args)
 * @method static void flushMacros()
 * @method static void getOption(string $key, void $default = null)
 * @method static array getOptions()
 * @method static string getSoarBinary()
 * @method static string|null getSudoPassword()
 * @method static bool hasMacro(string $name)
 * @method static string help()
 * @method static string htmlScores(array|string $sqls)
 * @method static string jsonScores(array|string $sqls)
 * @method static void macro(string $name, object|callable $macro)
 * @method static mixed macroCall(string $method, array $parameters)
 * @method static string markdownScores(array|string $sqls)
 * @method static \Guanguans\SoarPHP\Soar mergeOption(string $key, void $value)
 * @method static \Guanguans\SoarPHP\Soar mergeOptions(array $options)
 * @method static void mixin(object $mixin, bool $replace = true)
 * @method static \Guanguans\SoarPHP\Soar onlyDsn()
 * @method static \Guanguans\SoarPHP\Soar onlyOption(string $key)
 * @method static \Guanguans\SoarPHP\Soar onlyOptions(array $keys)
 * @method static \Guanguans\SoarPHP\Soar removeOption(string $key)
 * @method static \Guanguans\SoarPHP\Soar removeOptions(array $keys)
 * @method static string run(array|string $withOptions = [], callable|null $callback = null)
 * @method static string scores(array|string $sqls)
 * @method static \Guanguans\SoarPHP\Soar setOption(string $key, void $value)
 * @method static \Guanguans\SoarPHP\Soar setOptions(array $options)
 * @method static \Guanguans\SoarPHP\Soar setProcessTapper(callable|null $processTapper)
 * @method static \Guanguans\SoarPHP\Soar setSoarBinary(string $soarBinary)
 * @method static \Guanguans\SoarPHP\Soar setSudoPassword(string|null $sudoPassword)
 * @method static \Guanguans\LaravelSoar\Soar|\Illuminate\Support\HigherOrderTapProxy tap(callable|null $callback = null)
 * @method static string version()
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

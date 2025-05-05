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
 * @method static string help()
 * @method static string version()
 * @method static \Guanguans\SoarPHP\Soar clone()
 * @method static array arrayScores(array|string $sqls, int $depth = 512, int $options = 0)
 * @method static string jsonScores(array|string $sqls)
 * @method static string htmlScores(array|string $sqls)
 * @method static string markdownScores(array|string $sqls)
 * @method static string scores(array|string $sqls)
 * @method static \Guanguans\SoarPHP\Soar flushOptions()
 * @method static \Guanguans\SoarPHP\Soar setOption(string $name, mixed $value)
 * @method static \Guanguans\SoarPHP\Soar setOptions(array $options)
 * @method static \Guanguans\SoarPHP\Soar withOption(string $name, mixed $value)
 * @method static \Guanguans\SoarPHP\Soar withOptions(array $options)
 * @method static string getDelimiter(string $default = ';')
 * @method static mixed getOption(string $name, mixed $default = null)
 * @method static array getOptions()
 * @method static \Guanguans\SoarPHP\Soar onlyDsn()
 * @method static \Guanguans\SoarPHP\Soar onlyOption(string $name)
 * @method static \Guanguans\SoarPHP\Soar onlyOptions(array $names)
 * @method static \Guanguans\SoarPHP\Soar exceptOption(string $name)
 * @method static \Guanguans\SoarPHP\Soar exceptOptions(array $names)
 * @method static string getSoarBinary()
 * @method static \Guanguans\SoarPHP\Soar setSoarBinary(string $soarBinary)
 * @method static string|null getSudoPassword()
 * @method static \Guanguans\SoarPHP\Soar setSudoPassword(string|null $sudoPassword)
 * @method static \Guanguans\SoarPHP\Soar make(mixed ...$parameters)
 * @method static void dd(mixed ...$args)
 * @method static \Guanguans\SoarPHP\Soar dump(mixed ...$args)
 * @method static \Guanguans\SoarPHP\Soar setProcessTapper(callable|null $processTapper)
 * @method static string run(null|callable $callback = null)
 * @method static void macro(string $name, object|callable $macro)
 * @method static void mixin(object $mixin, bool $replace = true)
 * @method static bool hasMacro(string $name)
 * @method static void flushMacros()
 * @method static mixed macroCall(string $method, array $parameters)
 * @method static \Guanguans\LaravelSoar\Soar|\Illuminate\Support\HigherOrderTapProxy tap(callable|null $callback = null)
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

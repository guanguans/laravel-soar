<?php

/** @noinspection PhpFullyQualifiedNameUsageInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2020-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-soar
 */

namespace Guanguans\LaravelSoar\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string help(null|callable $callback = null)
 * @method static string version(null|callable $callback = null)
 * @method static \Guanguans\SoarPHP\Soar clone()
 * @method static array arrayScores(array|string $queries, int $depth = 512, int $options = 0)
 * @method static string jsonScores(array|string $queries)
 * @method static string htmlScores(array|string $queries)
 * @method static string markdownScores(array|string $queries)
 * @method static string scores(array|string $queries, null|callable $callback = null)
 * @method static string getBinary()
 * @method static \Guanguans\SoarPHP\Soar withBinary(string $binary)
 * @method static string defaultBinary()
 * @method static \Guanguans\SoarPHP\Soar flushOptions()
 * @method static \Guanguans\SoarPHP\Soar setOption(string $name, mixed $value)
 * @method static \Guanguans\SoarPHP\Soar setOptions(array $options)
 * @method static \Guanguans\SoarPHP\Soar withOption(string $name, mixed $value)
 * @method static \Guanguans\SoarPHP\Soar withOptions(array $options)
 * @method static mixed getOption(string $name, mixed $default = null)
 * @method static array getOptions()
 * @method static \Guanguans\SoarPHP\Soar onlyDsn()
 * @method static \Guanguans\SoarPHP\Soar onlyOption(string $name)
 * @method static \Guanguans\SoarPHP\Soar onlyOptions(array $names)
 * @method static \Guanguans\SoarPHP\Soar exceptOption(string $name)
 * @method static \Guanguans\SoarPHP\Soar exceptOptions(array $names)
 * @method static string|null getSudoPassword()
 * @method static \Guanguans\SoarPHP\Soar withoutSudoPassword()
 * @method static \Guanguans\SoarPHP\Soar withSudoPassword(string|null $sudoPassword)
 * @method static \Guanguans\SoarPHP\Soar make(mixed ...$parameters)
 * @method static void dd(mixed ...$args)
 * @method static \Guanguans\SoarPHP\Soar dump(mixed ...$args)
 * @method static \Guanguans\SoarPHP\Soar withPipe(\Closure|null $pipe)
 * @method static \Guanguans\SoarPHP\Soar withTap(\Closure|null $tap)
 * @method static string run(null|callable $callback = null)
 * @method static \Guanguans\LaravelSoar\Soar|mixed when(\Closure|mixed|null $value = null, callable|null $callback = null, callable|null $default = null)
 * @method static \Guanguans\LaravelSoar\Soar|mixed unless(\Closure|mixed|null $value = null, callable|null $callback = null, callable|null $default = null)
 * @method static mixed withLocale(string $locale, \Closure $callback)
 * @method static void macro(string $name, object|callable $macro)
 * @method static void mixin(object $mixin, bool $replace = true)
 * @method static bool hasMacro(string $name)
 * @method static void flushMacros()
 * @method static mixed macroCall(string $method, array $parameters)
 * @method static \Guanguans\LaravelSoar\Soar|\Illuminate\Support\HigherOrderTapProxy tap(callable|null $callback = null)
 *
 * @see \Guanguans\LaravelSoar\Soar
 */
class Soar extends Facade
{
    /**
     * @noinspection PhpMissingParentCallCommonInspection
     * @noinspection MethodVisibilityInspection
     */
    protected static function getFacadeAccessor(): string
    {
        return \Guanguans\LaravelSoar\Soar::class;
    }
}

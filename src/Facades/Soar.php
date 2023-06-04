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
 * @method static \Guanguans\LaravelSoar\Soar create(array $options = [], null|string $soarPath = null)
 * @method static string help()
 * @method static string version()
 * @method static \Guanguans\LaravelSoar\Soar clone()
 * @method static array arrayScores(array|string $sqls, int $depth = 512, int $options = 0)
 * @method static string jsonScores(array|string $sqls)
 * @method static string htmlScores(array|string $sqls)
 * @method static string markdownScores(array|string $sqls)
 * @method static string scores(array|string $sqls)
 * @method static \Guanguans\LaravelSoar\Soar addOptions(array $options)
 * @method static \Guanguans\LaravelSoar\Soar addOption(string $key, void $value)
 * @method static \Guanguans\LaravelSoar\Soar removeOptions(array $keys)
 * @method static \Guanguans\LaravelSoar\Soar removeOption(string $key)
 * @method static \Guanguans\LaravelSoar\Soar onlyOptions(array $keys = ['-test-dsn','-online-dsn'])
 * @method static \Guanguans\LaravelSoar\Soar onlyOption(string $key)
 * @method static \Guanguans\LaravelSoar\Soar setOptions(array $options)
 * @method static \Guanguans\LaravelSoar\Soar setOption(string $key, void $value)
 * @method static \Guanguans\LaravelSoar\Soar mergeOptions(array $options)
 * @method static \Guanguans\LaravelSoar\Soar mergeOption(string $key, void $value)
 * @method static array getOptions()
 * @method static void getOption(string $key, void $default = null)
 * @method static string getSerializedNormalizedOptions()
 * @method static array getNormalizedOptions()
 * @method static string getSoarPath()
 * @method static \Guanguans\LaravelSoar\Soar setSoarPath(string $soarPath)
 * @method static void dd(void ...$args)
 * @method static \Guanguans\LaravelSoar\Soar dump(void ...$args)
 * @method static string run(array|string $withOptions = [], null|callable $processTapper = null, null|callable $callback = null)
 * @method static \Guanguans\LaravelSoar\Soar|\Illuminate\Support\HigherOrderTapProxy tap(null|callable $callback = null)
 *
 * @see \Guanguans\LaravelSoar\Soar
 */
class Soar extends Facade
{
    /**
     * @noinspection ReturnTypeCanBeDeclaredInspection
     * @noinspection MissingParentCallInspection
     *
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return \Guanguans\LaravelSoar\Soar::class;
    }
}

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
 * @method static \self create(array $options = [], null|string $soarPath = null)
 * @method static string help()
 * @method static string version()
 * @method static \self clone()
 * @method static array arrayScores(array|string $sqls, int $depth = 512, int $options = 0)
 * @method static string jsonScores(array|string $sqls)
 * @method static string htmlScores(array|string $sqls)
 * @method static string markdownScores(array|string $sqls)
 * @method static string scores(array|string $sqls)
 * @method static \self addOptions(array $options)
 * @method static \self addOption(string $key, void $value)
 * @method static \self removeOptions(array $keys)
 * @method static \self removeOption(string $key)
 * @method static \self onlyOptions(array $keys = ['-test-dsn','-online-dsn'])
 * @method static \self onlyOption(string $key)
 * @method static \self setOptions(array $options)
 * @method static \self setOption(string $key, void $value)
 * @method static \self mergeOptions(array $options)
 * @method static \self mergeOption(string $key, void $value)
 * @method static array getOptions()
 * @method static void getOption(string $key, void $default = null)
 * @method static string getSerializedNormalizedOptions()
 * @method static array getNormalizedOptions()
 * @method static string getSoarPath()
 * @method static \self setSoarPath(string $soarPath)
 * @method static void dd(void ...$args)
 * @method static \self dump(void ...$args)
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
        return 'soar';
    }
}

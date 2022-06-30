<?php

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
 * Soar 门面.
 *
 * @method static string score(string $sql)                                                                 // SQL 评分
 * @method static array arrayScore(string $sql)                                                             // SQL 数组格式评分
 * @method static string jsonScore(string $sql)                                                             // SQL json 格式评分
 * @method static string htmlScore(string $sql)                                                             // SQL html 格式评分
 * @method static string mdScore(string $sql)                                                               // SQL markdown 格式评分
 * @method static string explain(string $sql)                                                               // explain 解读信息
 * @method static string mdExplain(string $sql)                                                             // markdown 格式 explain 解读信息
 * @method static string htmlExplain(string $sql)                                                           // html 格式 explain 解读信息
 * @method static null|string syntaxCheck(string $sql)                                                      // 语法检查
 * @method static string fingerPrint(string $sql)                                                           // SQL 指纹
 * @method static string pretty(string $sql)                                                                // 格式化 SQL
 * @method static string md2html(string $sql)                                                               // markdown 转 html
 * @method static string help()                                                                             // Soar 帮助
 * @method static null|string exec(string $command)                                                         // 执行任意 Soar 命令
 * @method static string getSoarPath()                                                                      // 获取 Soar 路径
 * @method static array getOptions()                                                                        // 获取 Soar 配置选项
 * @method static \Guanguans\LaravelSoar\Soar setSoarPath(string $soarPath)                                 // 设置 Soar 路径
 * @method static \Guanguans\LaravelSoar\Soar setOption(string $key, $value)                                // 设置 Soar 配置选项
 * @method static \Guanguans\LaravelSoar\Soar setOptions(array $options)                                    // 批量设置 Soar 配置选项
 * @method static \Guanguans\LaravelSoar\Soar|\Illuminate\Support\HigherOrderTapProxy tap($callback = null)
 *
 * @mixin \Illuminate\Support\Traits\Macroable
 *
 * @see \Guanguans\LaravelSoar\Soar
 */
class Soar extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'soar';
    }
}

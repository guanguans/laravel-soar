<?php

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Guanguans\SoarPHP\Support\OsHelper;

return [
    /*
     * soar 路径
     */
    '-soar-path' => env(
        'SOAR_FILE',
        OsHelper::isWindows()
        ? base_path('vendor/guanguans/soar-php/bin/soar.windows-amd64')
        : (OsHelper::isMacOS()
            ? base_path('vendor/guanguans/soar-php/bin/soar.darwin-amd64')
            : base_path('vendor/guanguans/soar-php/bin/soar.linux-amd64')
        )
    ),

    /*
     * 测试环境配置
     */
    '-test-dsn' => [
        'host' => env('DB_HOST', 'you_host'),
        'port' => env('DB_PORT', 'you_port'),
        'dbname' => env('DB_DATABASE', 'you_dbname'),
        'username' => env('DB_USERNAME', 'you_username'),
        'password' => env('DB_PASSWORD', 'you_password'),
        'disable' => false,
    ],

    /*
     * 线上环境配置
     * 线上数据库用户只需 select 权限
     */
    '-online-dsn' => [
        'host' => env('DB_HOST', 'you_host'),
        'port' => env('DB_PORT', 'you_port'),
        'dbname' => env('DB_DATABASE', 'you_dbname'),
        'username' => env('DB_USERNAME', 'you_username'),
        'password' => env('DB_PASSWORD', 'you_password'),
        'disable' => true,
    ],

    /*
     * 日志输出文件
     */
    '-log-output' => env('SOAR_LOG_FILE', storage_path('logs/soar.log')),

    /*
     * 日志级别:
     * ```
     * 0 => 'Emergency',
     * 1 => 'Alert',
     * 2 => 'Critical',
     * 3 => 'Error',
     * 4 => 'Warning',
     * 5 => 'Notice',
     * 6 => 'Informational',
     * 7 => 'Debug',
     * ```
     */
    '-log-level' => 4,

    /*
     * 报告输出格式: [markdown, html, json]
     */
    '-report-type' => 'html',

    //+----------------------------------------------------------------------+//
    //|           以下配置请参考 @see https://github.com/XiaoMi/soar            |//
    //+----------------------------------------------------------------------+//

    // // 是否允许测试环境与线上环境配置相同
    // '-allow-online-as-test' => true,
    //
    // // 是否清理测试时产生的临时文件
    // '-drop-test-temporary'  => true,
    //
    // // 语法检查小工具
    // '-only-syntax-check'    => false,
    //
    // '-sampling-statistic-target' => 100,
    // '-sampling'                  => false,
    //
    // // 日志级别: [0=>Emergency, 1=>Alert, 2=>Critical, 3=>Error, 4=>Warning, 5=>Notice, 6=>Informational, 7=>Debug]
    // '-log-level'                 => 7,
    // '-log-output'                => 'soar.log',
    //
    // // 优化建议输出格式
    // '-report-type'               => 'markdown',
    //
    // // 忽略规则
    // '-ignore-rules'              => [],
    //
    // // 黑名单中的 SQL 将不会给评审意见。一行一条 SQL，可以是正则也可以是指纹，填写指纹时注意问号需要加反斜线转义。
    // '-blacklist'                 => './soar.blacklist',
    //
    // // 启发式算法相关配置
    // '-max-join-table-count'      => 5,
    // '-max-group-by-cols-count'   => 5,
    // '-max-distinct-count'        => 5,
    // '-max-index-cols-count'      => 5,
    // '-max-total-rows'            => 9999999,
    // '-spaghetti-query-length'    => 2048,
    // '-allow-drop-index'          => false,
    //
    // // EXPLAIN相关配置
    // '-explain-sql-report-type'   => 'pretty',
    // '-explain-type'              => 'extended',
    // '-explain-format'            => 'traditional',
    // '-explain-warn-select-type'  => [],
    // '-explain-warn-access-type'  => [],
    // '-explain-max-keys'          => 3,
    // '-explain-min-keys'          => 0,
    // '-explain-max-rows'          => 10000,
    // '-explain-warn-extra'        => [],
    // '-explain-max-filtered'      => 100,
    // '-explain-warn-scalability'  => [],
    //
    // '-query'                => "",
    // '-list-heuristic-rules' => false,
    // '-list-test-sqls'       => false,
    // '-verbose'              => true,
    //
    // '-config' => 'soar.yaml'
];

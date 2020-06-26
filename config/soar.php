<?php

/*
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

return [
    /**
     * soar 路径
     */
    '-soar-path'   => env('SOAR_FILE', 'you_soar_path'),

    /**
     * 测试环境配置
     */
    '-test-dsn'    => [
        'host'     => env('DB_HOST', 'you_host'),
        'port'     => env('DB_PORT', 'you_port'),
        'dbname'   => env('DB_DATABASE', 'you_dbname'),
        'username' => env('DB_USERNAME', 'you_username'),
        'password' => env('DB_PASSWORD', 'you_password'),
        'disable'  => false,
    ],

    /**
     * 线上环境配置
     * 线上数据库用户只需 select 权限
     */
    '-online-dsn'  => [
        'host'     => env('DB_HOST', 'you_host'),
        'port'     => env('DB_PORT', 'you_port'),
        'dbname'   => env('DB_PORT', 'you_port'),
        'username' => env('DB_PORT', 'you_port'),
        'password' => env('DB_PORT', 'you_port'),
        'disable'  => true,
    ],

    /**
     * 日志输出文件
     */
    '-log-output'  => env('SOAR_LOG_FILE', storage_path('logs/soar.log')),

    /**
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
    '-log-level'   => 7,

    /**
     * 报告输出格式: [markdown, html, json]
     */
    '-report-type' => 'html',
];
<?php

/*
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

return [
    // soar 路径
    '-soar-path'   => env('SOAR_FILE', 'you_soar_path'),
    // 线上环境配置
    '-online-dsn'  => [
        'host'     => '',
        'port'     => '',
        'dbname'   => '',
        'username' => '', // 线上数据库用户只需 select 权限
        'password' => '',
        'disable'  => true,
    ],
    // 测试环境配置
    '-test-dsn'    => [
        'host'     => config('database.hostname') ? config('database.hostname') : 'you_host',
        'port'     => config('database.hostport') ? config('database.hostport') : 'you_port',
        'dbname'   => config('database.database') ? config('database.database') : 'you_dbname',
        'username' => config('database.username') ? config('database.username') : 'you_username',
        'password' => config('database.password') ? config('database.password') : 'you_password',
        'disable'  => false,
    ],
    // 日志输出文件
    '-log-output'  => env('SOAR_LOG_FILE', app()->getRuntimePath()."log/soar.log"),
    // 日志级别: [0=>Emergency, 1=>Alert, 2=>Critical, 3=>Error, 4=>Warning, 5=>Notice, 6=>Informational, 7=>Debug]
    '-log-level'   => 7,
    // 报告输出格式: [markdown, html, json]
    '-report-type' => 'html',
];
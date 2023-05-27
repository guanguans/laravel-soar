<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

return [
    /*
    |--------------------------------------------------------------------------
    | 启用 soar 评分
    |--------------------------------------------------------------------------
    */
    'enabled' => (bool) env('SOAR_SCORE_ENABLED', config('app.debug')),

    /*
    |--------------------------------------------------------------------------
    | soar 路径
    |--------------------------------------------------------------------------
    */
    'path' => env('SOAR_PATH'),

    /*
    |--------------------------------------------------------------------------
    | 排除 soar 评分的 sql
    |--------------------------------------------------------------------------
    */
    'except' => [
        '*telescope*',
        '*horizon*',
        // 'create table*',
    ],

    /*
    |--------------------------------------------------------------------------
    | soar 评分输出
    |--------------------------------------------------------------------------
    */
    'output' => [
        Guanguans\LaravelSoar\Outputs\ClockworkOutput::class,
        Guanguans\LaravelSoar\Outputs\ConsoleOutput::class,
        Guanguans\LaravelSoar\Outputs\DumpOutput::class => ['exit' => false],
        Guanguans\LaravelSoar\Outputs\JsonOutput::class,
        Guanguans\LaravelSoar\Outputs\LogOutput::class => ['channel' => 'daily'],
        Guanguans\LaravelSoar\Outputs\DebugBarOutput::class,
        Guanguans\LaravelSoar\Outputs\SoarBarOutput::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | soar 选项配置(参考 @see https://github.com/XiaoMi/soar)
    |--------------------------------------------------------------------------
    */
    'options' => [
        // 测试环境配置
        '-test-dsn' => [
            'host' => env('SOAR_TEST_DB_HOST', config('database.connections.mysql.host', 'you_host')),
            'port' => env('SOAR_TEST_DB_PORT', config('database.connections.mysql.port', 'you_port')),
            'dbname' => env('SOAR_TEST_DB_DATABASE', config('database.connections.mysql.database', 'you_dbname')),
            'username' => env('SOAR_TEST_DB_USERNAME', config('database.connections.mysql.username', 'you_username')),
            'password' => env('SOAR_TEST_DB_PASSWORD', config('database.connections.mysql.password', 'you_password')),
            'disable' => env('SOAR_TEST_DB_DISABLE', false),
        ],

        // 线上环境配置(线上数据库用户只需 select 权限)
        '-online-dsn' => [
            'host' => env('SOAR_ONLINE_DB_HOST', config('database.connections.mysql.host', 'you_host')),
            'port' => env('SOAR_ONLINE_DB_PORT', config('database.connections.mysql.port', 'you_port')),
            'dbname' => env('SOAR_ONLINE_DB_DATABASE', config('database.connections.mysql.database', 'you_dbname')),
            'username' => env('SOAR_ONLINE_DB_USERNAME', config('database.connections.mysql.username', 'you_username')),
            'password' => env('SOAR_ONLINE_DB_PASSWORD', config('database.connections.mysql.password', 'you_password')),
            'disable' => env('SOAR_ONLINE_DB_DISABLE', true),
        ],

        // 日志输出文件
        '-log-output' => env('SOAR_LOG_PATH', storage_path('logs/soar.log')),

        // 黑名单中的 SQL 将不会给评审意见。一行一条 SQL，可以是正则也可以是指纹，填写指纹时注意问号需要加反斜线转义。
        '-blacklist' => env('SOAR_BLACKLIST_PATH', base_path('vendor/guanguans/soar-php/soar.blacklist.example')),

        // 忽略规则
        '-ignore-rules' => [],

        /*
         * 日志级别
         * ```
         * [
         *     0 => 'Emergency',
         *     1 => 'Alert',
         *     2 => 'Critical',
         *     3 => 'Error',
         *     4 => 'Warning',
         *     5 => 'Notice',
         *     6 => 'Informational',
         *     7 => 'Debug'
         * ]
         * ```
         */
        '-log-level' => 3,

        // 是否允许测试环境与线上环境配置相同
        '-allow-online-as-test' => true,

        // 是否清理测试时产生的临时文件
        '-drop-test-temporary' => true,

        // 启发式算法相关配置
        '-max-join-table-count' => 5,
        '-max-group-by-cols-count' => 5,
        '-max-distinct-count' => 5,
        '-max-index-cols-count' => 5,
        '-max-total-rows' => 9999999,
        '-spaghetti-query-length' => 2048,
        // '-allow-drop-index' => false,

        // EXPLAIN 相关配置
        '-explain-sql-report-type' => 'pretty',
        '-explain-type' => 'extended',
        '-explain-format' => 'traditional',
        '-explain-warn-select-type' => [],
        '-explain-warn-access-type' => [],
        '-explain-max-keys' => 3,
        '-explain-min-keys' => 0,
        '-explain-max-rows' => 10000,
        '-explain-warn-extra' => [],
        '-explain-max-filtered' => 100,
        '-explain-warn-scalability' => [],

        // /*
        //  * 报告输出格式
        //  * ```
        //  * [
        //  *     markdown,              // 该格式为默认输出格式，以 markdown 格式展现，可以用网页浏览器插件直接打开，也可以用 markdown 编辑器打开
        //  *     html,                  // 以 HTML 格式输出报表
        //  *     json,                  // 输出JSON格式报表，方便应用程序处理
        //  *     lint,                  // 参考 sqlint 格式，以插件形式集成到代码编辑器，显示输出更加友好
        //  *     rewrite,               // SQL 重写功能，配合 -rewrite-rules 参数一起使用，可以通过 -list-rewrite-rules 查看所有支持的 SQL 重写规则
        //  *     ast,                   // 输出 SQL 的抽象语法树，主要用于测试
        //  *     ast-json,              // 以 JSON 格式输出 SQL 的抽象语法树，主要用于测试
        //  *     tiast,                 // 输出 SQL 的 TiDB抽象语法树，主要用于测试
        //  *     tiast-json,            // 以 JSON 格式输出 SQL 的 TiDB抽象语法树，主要用于测试
        //  *     tables,                // 以 JSON 格式输出 SQL 使用的库表名
        //  *     query-type,            // SQL 语句的请求类型
        //  *     fingerprint,           // 输出 SQL 的指纹
        //  *     md2html,               // markdown 格式转 html 格式小工具
        //  *     explain-digest,        // 输入为EXPLAIN的表格，JSON 或 Vertical格式，对其进行分析，给出分析结果
        //  *     duplicate-key-checker, // 对 OnlineDsn 中指定的 database 进行索引重复检查
        //  *     tokenize,              // 对 SQL 进行切词，主要用于测试
        //  *     compress,              // SQL压缩小工具，使用内置SQL压缩逻辑，测试中的功能
        //  *     pretty,                // 使用 kr/pretty 打印报告，主要用于测试
        //  *     remove-comment,        // 去除 SQL 语句中的注释，支持单行多行注释的去除
        //  *     chardet                // 猜测输入的 SQL 使用的字符集
        //  * ]
        //  * ```
        //  */
        // '-report-type' => 'json',
        //
        // /*
        //  * 语法检查小工具
        //  */
        // '-only-syntax-check' => false,
        //
        // /*
        //  * 抽样统计目标
        //  */
        // '-sampling-statistic-target' => 100,
        // '-sampling' => false,
        //
        // /*
        //  * query 相关配置
        //  */
        // '-query' => '',
        // '-list-heuristic-rules' => false,
        // '-list-test-sqls' => false,
        // '-verbose' => true,
        //
        // /*
        //  * yaml 配置文件
        //  */
        // '-config' => base_path('soar.yaml'),
    ],
];

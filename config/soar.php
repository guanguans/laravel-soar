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

use Guanguans\LaravelSoar\Outputs;
use function Guanguans\LaravelSoar\Support\env_explode;

return [
    // 是否启用自动评分
    'enabled' => (bool) env('SOAR_ENABLED', false),

    // 二进制文件
    'binary' => env('SOAR_BINARY'),

    // sudo 密码(在 unix 操作系统非 cli 环境中运行时需要设置)
    'sudo_password' => env('SOAR_SUDO_PASSWORD'),

    // 排除评分的命令、请求路径、请求路由
    'except' => env_explode('SOAR_EXCEPT', [
        'telescope:*',
        '*telescope*',
    ]),

    // 排除评分的查询
    'except_queries' => env_explode('SOAR_EXCEPT_QUERIES', [
        '^use \?$',
        '^set.*',
        '^show.*',
        '^select \?$',
        '^\/\*.*\*\/$',
        '^drop.*',
        '^lock.*',
        '^unlock.*',

        '*telescope*',
        '*horizon*',
        // 'create table*',
    ]),

    // 评分输出器
    'outputs' => [
        // Outputs\ClockworkOutput::class,
        // Outputs\ConsoleOutput::class => ['method' => 'warn'],
        // Outputs\DebugBarOutput::class => ['name' => 'Soar Scores', 'label' => 'warning'],
        // Outputs\DumpOutput::class => ['exit' => false],
        // Outputs\JsonOutput::class => ['key' => 'soar_scores'],
        // Outputs\LaraDumpsOutput::class => ['label' => 'Soar Scores'],
        Outputs\LogOutput::class => ['channel' => 'daily', 'level' => 'warning'],
        // Outputs\RayOutput::class => ['label' => 'Soar Scores'],
    ],

    /**
     * @see https://github.com/guanguans/soar-php/blob/master/examples/soar-options-example.php
     * @see https://github.com/guanguans/soar-php/blob/master/examples/soar-options.php
     * @see https://github.com/XiaoMi/soar
     */
    'options' => [
        // // Config file path
        // '-config' => null,

        // TestDSN, 测试环境数据库配置, username:********@tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
        '-test-dsn' => [
            'host' => env('SOAR_TEST_DSN_HOST', config('database.connections.mysql.host', 'you_host')),
            'port' => env('SOAR_TEST_DSN_PORT', config('database.connections.mysql.port', 'you_port')),
            'schema' => env('SOAR_TEST_DSN_SCHEMA', config('database.connections.mysql.database', 'you_schema')),
            'user' => env('SOAR_TEST_DSN_USER', config('database.connections.mysql.username', 'you_user')),
            'password' => env('SOAR_TEST_DSN_PASSWORD', config('database.connections.mysql.password', 'you_password')),
            'disable' => env('SOAR_TEST_DSN_DISABLE', false),
        ],

        // OnlineDSN, 线上环境数据库配置(数据库用户只需 select 权限), username:********@tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
        '-online-dsn' => [
            'host' => env('SOAR_ONLINE_DSN_HOST', config('database.connections.mysql.host', 'you_host')),
            'port' => env('SOAR_ONLINE_DSN_PORT', config('database.connections.mysql.port', 'you_port')),
            'schema' => env('SOAR_ONLINE_DSN_SCHEMA', config('database.connections.mysql.database', 'you_schema')),
            'user' => env('SOAR_ONLINE_DSN_USER', config('database.connections.mysql.username', 'you_user')),
            'password' => env('SOAR_ONLINE_DSN_PASSWORD', config('database.connections.mysql.password', 'you_password')),
            'disable' => env('SOAR_ONLINE_DSN_DISABLE', true),
        ],

        // AllowOnlineAsTest, 允许线上环境也可以当作测试环境
        '-allow-online-as-test' => env('SOAR_ALLOW_ONLINE_AS_TEST', true),

        // 指定 blacklist 配置文件的位置，文件中的 SQL 不会被评审。一行一条SQL，可以是指纹，也可以是正则
        '-blacklist' => env('SOAR_BLACKLIST', base_path('vendor/guanguans/soar-php/examples/soar.blacklist.example')),

        // Explain, 是否开启Explain执行计划分析 (default true)
        '-explain' => env('SOAR_EXPLAIN', true),

        // IgnoreRules, 忽略的优化建议规则 (default "COL.011")
        '-ignore-rules' => env_explode('SOAR_IGNORE_RULES', [
            'COL.011',
        ]),

        // LogLevel, 日志级别, [0:Emergency, 1:Alert, 2:Critical, 3:Error, 4:Warning, 5:Notice, 6:Informational, 7:Debug] (default 3)
        '-log-level' => env('SOAR_LOG_LEVEL', 3),

        // LogOutput, 日志输出位置 (default "soar.log")
        '-log-output' => env('SOAR_LOG_OUTPUT', storage_path('logs/soar.log')),

        // ReportType, 优化建议输出格式，目前支持: json, text, markdown, html等 (default "markdown")
        '-report-type' => env('SOAR_REPORT_TYPE', 'json'),

        // // AllowCharsets (default "utf8,utf8mb4")
        // '-allow-charsets' => [
        //     'utf8',
        //     'utf8mb4',
        // ],
        //
        // // AllowCollates
        // '-allow-collates' => [
        // ],
        //
        // // AllowDropIndex, 允许输出删除重复索引的建议
        // '-allow-drop-index' => false,
        //
        // // AllowEngines (default "innodb")
        // '-allow-engines' => [
        //     'innodb',
        // ],
        //
        // // Check configs
        // '-check-config' => null,
        //
        // // 单次运行清理历史1小时前残余的测试库。
        // '-cleanup-test-database' => false,
        //
        // // ColumnNotAllowType (default "boolean")
        // '-column-not-allow-type' => [
        //     'boolean',
        // ],
        //
        // // Delimiter, SQL分隔符 (default ";")
        // '-delimiter' => ';',
        //
        // // DropTestTemporary, 是否清理测试环境产生的临时库表 (default true)
        // '-drop-test-temporary' => true,
        //
        // // 是否在预演环境执行 (default true)
        // '-dry-run' => true,
        //
        // // ExplainFormat [json, traditional] (default "traditional")
        // '-explain-format' => 'traditional',
        //
        // // ExplainMaxFiltered, filtered大于该配置给出警告 (default 100)
        // '-explain-max-filtered' => 100,
        //
        // // ExplainMaxKeyLength, 最大key_len (default 3)
        // '-explain-max-keys' => 3,
        //
        // // ExplainMaxRows, 最大扫描行数警告 (default 10000)
        // '-explain-max-rows' => 10000,
        //
        // // ExplainMinPossibleKeys, 最小possible_keys警告
        // '-explain-min-keys' => 0,
        //
        // // ExplainSQLReportType [pretty, sample, fingerprint] (default "pretty")
        // '-explain-sql-report-type' => 'pretty',
        //
        // // ExplainType [extended, partitions, traditional] (default "extended")
        // '-explain-type' => 'extended',
        //
        // // ExplainWarnAccessType, 哪些access type不建议使用 (default "ALL")
        // '-explain-warn-access-type' => [
        //     'ALL',
        // ],
        //
        // // ExplainWarnExtra, 哪些extra信息会给警告 (default "Using temporary,Using filesort")
        // '-explain-warn-extra' => [
        //     'Using temporary',
        //     'Using filesort',
        // ],
        //
        // // ExplainWarnScalability, 复杂度警告名单, 支持O(n),O(log n),O(1),O(?) (default "O(n)")
        // '-explain-warn-scalability' => [
        //     'O(n)',
        // ],
        //
        // // ExplainWarnSelectType, 哪些select_type不建议使用
        // '-explain-warn-select-type' => [
        //     '',
        // ],
        //
        // // Help
        // '-help' => null,
        //
        // // IdxPrefix (default "idx_")
        // '-index-prefix' => 'idx_',
        //
        // // ListHeuristicRules, 打印支持的评审规则列表
        // '-list-heuristic-rules' => false,
        //
        // // ListReportTypes, 打印支持的报告输出类型
        // '-list-report-types' => false,
        //
        // // ListRewriteRules, 打印支持的重写规则列表
        // '-list-rewrite-rules' => false,
        //
        // // ListTestSqls, 打印测试case用于测试
        // '-list-test-sqls' => false,
        //
        // // log stack traces for errors
        // '-log_err_stacks' => null,
        //
        // // size in bytes at which logs are rotated (glog.MaxSize) (default 1887436800)
        // '-log_rotate_max_size' => '1887436800',
        //
        // // MarkdownExtensions, markdown 转 html支持的扩展包, 参考blackfriday (default 94)
        // '-markdown-extensions' => 94,
        //
        // // MarkdownHTMLFlags, markdown 转 html 支持的 flag, 参考blackfriday
        // '-markdown-html-flags' => 0,
        //
        // // MaxColCount, 单表允许的最大列数 (default 40)
        // '-max-column-count' => 40,
        //
        // // MaxDistinctCount, 单条 SQL 中 Distinct 的最大数量 (default 5)
        // '-max-distinct-count' => 5,
        //
        // // MaxGroupByColsCount, 单条 SQL 中 GroupBy 包含列的最大数量 (default 5)
        // '-max-group-by-cols-count' => 5,
        //
        // // MaxInCount, IN()最大数量 (default 10)
        // '-max-in-count' => 10,
        //
        // // MaxIdxBytes, 索引总长度限制 (default 3072)
        // '-max-index-bytes' => 3072,
        //
        // // MaxIdxBytesPerColumn, 索引中单列最大字节数 (default 767)
        // '-max-index-bytes-percolumn' => 767,
        //
        // // MaxIdxColsCount, 复合索引中包含列的最大数量 (default 5)
        // '-max-index-cols-count' => 5,
        //
        // // MaxIdxCount, 单表最大索引个数 (default 10)
        // '-max-index-count' => 10,
        //
        // // MaxJoinTableCount, 单条 SQL 中 JOIN 表的最大数量 (default 5)
        // '-max-join-table-count' => 5,
        //
        // // MaxPrettySQLLength, 超出该长度的SQL会转换成指纹输出 (default 1024)
        // '-max-pretty-sql-length' => 1024,
        //
        // // MaxQueryCost, last_query_cost 超过该值时将给予警告 (default 9999)
        // '-max-query-cost' => 9999,
        //
        // // MaxSubqueryDepth (default 5)
        // '-max-subquery-depth' => 5,
        //
        // // MaxTextColsCount, 表中含有的 text/blob 列的最大数量 (default 2)
        // '-max-text-cols-count' => 2,
        //
        // // MaxTotalRows, 计算散粒度时，当数据行数大于MaxTotalRows即开启数据库保护模式，不计算散粒度 (default 9999999)
        // '-max-total-rows' => 9999999,
        //
        // // MaxValueCount, INSERT/REPLACE 单次批量写入允许的行数 (default 100)
        // '-max-value-count' => 100,
        //
        // // MaxVarcharLength (default 1024)
        // '-max-varchar-length' => 1024,
        //
        // // MinCardinality，索引列散粒度最低阈值，散粒度低于该值的列不添加索引，建议范围0.0 ~ 100.0
        // '-min-cardinality' => 0,
        //
        // // OnlySyntaxCheck, 只做语法检查不输出优化建议
        // '-only-syntax-check' => false,
        //
        // // Print configs
        // '-print-config' => null,
        //
        // // Profiling, 开启数据采样的情况下在测试环境执行Profile
        // '-profiling' => false,
        //
        // // 待评审的 SQL 或 SQL 文件，如 SQL 中包含特殊字符建议使用文件名。
        // '-query' => '',
        //
        // // ReportCSS, 当 ReportType 为 html 格式时使用的 css 风格，如不指定会提供一个默认风格。CSS可以是本地文件，也可以是一个URL
        // '-report-css' => '',
        //
        // // ReportJavascript, 当 ReportType 为 html 格式时使用的javascript脚本，如不指定默认会加载SQL pretty 使用的 javascript。像CSS一样可以是本地文件，也可以是一个URL
        // '-report-javascript' => '',
        //
        // // ReportTitle, 当 ReportType 为 html 格式时，HTML 的 title (default "SQL优化分析报告")
        // '-report-title' => 'SQL优化分析报告',
        //
        // // RewriteRules, 生效的重写规则 (default "delimiter,orderbynull,groupbyconst,dmlorderby,having,star2columns,insertcolumns,distinctstar")
        // '-rewrite-rules' => [
        //     'delimiter',
        //     'orderbynull',
        //     'groupbyconst',
        //     'dmlorderby',
        //     'having',
        //     'star2columns',
        //     'insertcolumns',
        //     'distinctstar',
        // ],
        //
        // // Sampling, 数据采样开关
        // '-sampling' => false,
        //
        // // SamplingCondition, 数据采样条件，如： WHERE xxx LIMIT xxx
        // '-sampling-condition' => '',
        //
        // // SamplingStatisticTarget, 数据采样因子，对应 PostgreSQL 的 default_statistics_target (default 100)
        // '-sampling-statistic-target' => 100,
        //
        // // ShowLastQueryCost
        // '-show-last-query-cost' => false,
        //
        // // ShowWarnings
        // '-show-warnings' => false,
        //
        // // SpaghettiQueryLength, SQL最大长度警告，超过该长度会给警告 (default 2048)
        // '-spaghetti-query-length' => 2048,
        //
        // // Trace, 开启数据采样的情况下在测试环境执行Trace
        // '-trace' => false,
        //
        // // UkPrefix (default "uk_")
        // '-unique-key-prefix' => 'uk_',
        //
        // // Verbose
        // '-verbose' => false,
        //
        // // Print version info
        // '-version' => null,
    ],
];

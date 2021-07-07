<?php

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Guanguans\SoarPHP\Support\OsHelper;

/**
 * @beforeMethods({"setUp"})
 * @warmup(2)
 * @revs(10)
 * @iterations(3)
 */
final class SoarBench
{
    /**
     * @var \Guanguans\LaravelSoar\Soar
     */
    private $soar;

    public function setUp(): void
    {
        $config = [
            // 包自带 soar 路径或者自定义的 soar 路径
            '-soar-path' => OsHelper::isWindows() ? __DIR__.'/../vendor/guanguans/soar-php/bin/soar.windows-amd64' : (OsHelper::isMacOS() ? __DIR__.'/../vendor/guanguans/soar-php/bin/soar.darwin-amd64' : __DIR__.'/../vendor/guanguans/soar-php/bin/soar.linux-amd64'),
            // 测试环境配置
            '-test-dsn' => [
                'host' => '127.0.0.1',
                'port' => '3306',
                'dbname' => 'database',
                'username' => 'root',
                'password' => '123456',
            ],
            // 日志输出文件
            '-log-output' => __DIR__.'/soar.log',
            // 报告输出格式: [markdown, html, json, ...]
            '-report-type' => 'html',
        ];

        $this->soar = new \Guanguans\LaravelSoar\Soar($config);
    }

    public function benchSyntaxCheck(): void
    {
        $this->soar->syntaxCheck('select * from user id = 1;');
    }

    public function benchPretty(): void
    {
        $this->soar->pretty('select * from user;');
    }

    public function benchMd2html(): void
    {
        $this->soar->md2html('## this is a testing.');
    }

    public function benchFingerPrint(): void
    {
        $this->soar->fingerPrint('select * from user where id = 1;');
    }

    public function benchHelp(): void
    {
        $this->soar->help();
    }
}

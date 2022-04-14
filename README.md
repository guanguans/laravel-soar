![](docs/debug-bar.png)

# laravel-soar

> SQL optimizer and rewriter for laravel. - laravel 的 SQL 优化器和重写器。

[简体中文](README.md) | [ENGLISH](README-EN.md)

[![Tests](https://github.com/guanguans/laravel-soar/workflows/Tests/badge.svg)](https://github.com/guanguans/laravel-soar/actions)
[![Check & fix styling](https://github.com/guanguans/laravel-soar/workflows/Check%20&%20fix%20styling/badge.svg)](https://github.com/guanguans/laravel-soar/actions)
[![codecov](https://codecov.io/gh/guanguans/laravel-soar/branch/master/graph/badge.svg?token=EWBG8GV4JD)](https://codecov.io/gh/guanguans/laravel-soar)
[![Latest Stable Version](https://poser.pugx.org/guanguans/laravel-soar/v)](//packagist.org/packages/guanguans/laravel-soar)
[![Total Downloads](https://poser.pugx.org/guanguans/laravel-soar/downloads)](//packagist.org/packages/guanguans/laravel-soar)
[![License](https://poser.pugx.org/guanguans/laravel-soar/license)](//packagist.org/packages/guanguans/laravel-soar)

## 功能

* 支持基于启发式算法的语句优化
* 支持复杂查询的多列索引优化（UPDATE, INSERT, DELETE, SELECT）
* 支持 EXPLAIN 信息丰富解读
* 支持 SQL 指纹、压缩和美化
* 支持同一张表多条 ALTER 请求合并
* 支持自定义规则的 SQL 改写
* 支持 Eloquent 查询构建器方法生成 SQL 优化报告

## 相关项目

* [https://github.com/XiaoMi/soar](https://github.com/XiaoMi/soar)
* [https://github.com/guanguans/soar-php](https://github.com/guanguans/soar-php)
* [https://github.com/huangdijia/laravel-web-soar](https://github.com/huangdijia/laravel-web-soar)
* [https://github.com/wilbur-yu/hyperf-soar](https://github.com/wilbur-yu/hyperf-soar)
* [https://github.com/guanguans/think-soar](https://github.com/guanguans/think-soar)

## 环境要求

* laravel >= 6.10

## 安装

```shell
$ composer require guanguans/laravel-soar --dev -vvv
```

## 配置

### 注册服务

#### laravel

```bash
$ php artisan vendor:publish --provider="Guanguans\\LaravelSoar\\SoarServiceProvider"
```

#### lumen

将以下代码段添加到 `bootstrap/app.php` 文件中的 `Register Service Providers` 部分下：

```php
$app->register(\Guanguans\LaravelSoar\SoarServiceProvider::class);
```

## 使用

### 监控输出 SQL 评分

![](docs/debug-bar.png)

### 接口方法

```php
$soar = app('soar'); // 获取 Soar 实例

/**
 * Soar 门面.
 *
 * @method static string score(string $sql)            // SQL 评分
 * @method static array arrayScore(string $sql)        // SQL 数组格式评分
 * @method static string jsonScore(string $sql)        // SQL json 格式评分
 * @method static string htmlScore(string $sql)        // SQL html 格式评分
 * @method static string mdScore(string $sql)          // SQL markdown 格式评分
 * @method static string explain(string $sql)          // explain 解读信息
 * @method static string mdExplain(string $sql)        // markdown 格式 explain 解读信息
 * @method static string htmlExplain(string $sql)      // html 格式 explain 解读信息
 * @method static null|string syntaxCheck(string $sql) // 语法检查
 * @method static string fingerPrint(string $sql)      // SQL 指纹
 * @method static string pretty(string $sql)           // 格式化 SQL
 * @method static string md2html(string $sql)          // markdown 转 html
 * @method static string help()                        // Soar 帮助
 * @method static null|string exec(string $command)    // 执行任意 Soar 命令
 * @method static string getSoarPath()                 // 获取 Soar 路径
 * @method static array getOptions()                   // 获取 Soar 配置选项
 * @method static Soar setSoarPath(string $soarPath)   // 设置 Soar 路径
 * @method static Soar setOption(string $key, $value)  // 设置 Soar 配置选项
 * @method static Soar setOptions(array $options)      // 批量设置 Soar 配置选项
 *
 * @see \Guanguans\SoarPHP\Soar
 */
class Soar{}
```

## 测试

```bash
$ composer test
```

## 变更日志

请参阅 [CHANGELOG](CHANGELOG.md) 获取最近有关更改的更多信息。

## 贡献指南

请参阅 [CONTRIBUTING](.github/CONTRIBUTING.md) 有关详细信息。

## 安全漏洞

请查看[我们的安全政策](../../security/policy)了解如何报告安全漏洞。

## 贡献者

* [guanguans](https://github.com/guanguans)
* [所有贡献者](../../contributors)

## 协议

MIT 许可证（MIT）。有关更多信息，请参见[协议文件](LICENSE)。

# laravel-soar

![](docs/debug-bar.png)

> SQL optimizer and rewriter for laravel. - laravel 的 SQL 优化器和重写器。

[![Tests](https://github.com/guanguans/laravel-soar/workflows/Tests/badge.svg)](https://github.com/guanguans/laravel-soar/actions)
[![Check & fix styling](https://github.com/guanguans/laravel-soar/workflows/Check%20&%20fix%20styling/badge.svg)](https://github.com/guanguans/laravel-soar/actions)
[![codecov](https://codecov.io/gh/guanguans/laravel-soar/branch/main/graph/badge.svg?token=URGFAWS6S4)](https://codecov.io/gh/guanguans/laravel-soar)
[![Latest Stable Version](https://poser.pugx.org/guanguans/laravel-soar/v)](//packagist.org/packages/guanguans/laravel-soar)
[![Total Downloads](https://poser.pugx.org/guanguans/laravel-soar/downloads)](//packagist.org/packages/guanguans/laravel-soar)
[![License](https://poser.pugx.org/guanguans/laravel-soar/license)](//packagist.org/packages/guanguans/laravel-soar)

## Feature

* Support sentence optimization based on heuristic algorithm
* Support multi-column index optimization for complex queries (UPDATE, INSERT, DELETE, SELECT)
* Support EXPLAIN informative interpretation
* Support SQL fingerprint, compression and beautification
* Support multiple ALTER request merging of the same table
* Support SQL rewriting of custom rules
* Support Eloquent query builder method to generate SQL optimization report

## Related Links

* [https://github.com/XiaoMi/soar](https://github.com/XiaoMi/soar)
* [https://github.com/guanguans/soar-php](https://github.com/guanguans/soar-php)
* [https://github.com/huangdijia/laravel-web-soar](https://github.com/huangdijia/laravel-web-soar)
* [https://github.com/wilbur-yu/hyperf-soar](https://github.com/wilbur-yu/hyperf-soar)
* [https://github.com/guanguans/think-soar](https://github.com/guanguans/think-soar)

## Requirement

* laravel >= 5.5

## Installation

```shell
$ composer require guanguans/laravel-soar --dev -vvv
```

## Configuration

### Register service

#### laravel

```bash
$ php artisan vendor:publish --provider="Guanguans\\LaravelSoar\\SoarServiceProvider"
```

#### lumen

Add the following snippet to the `bootstrap/app.php` file under the `Register Service Providers` section as follows:

```php
$app->register(\Guanguans\LaravelSoar\SoarServiceProvider::class);
```

## Usage

### Automatically monitor output sql score

![](docs/debug-bar.png)

### Example of use

```php
$soar = app('soar'); // get soar instance
User::query()->ddSoarJsonScore() // Convenience query method to output scoring report
\Soar::jsonScore(User::query()->toRawSql()); // soar facade generates scoring report
```

## Testing

```bash
$ composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

* [guanguans](https://github.com/guanguans)
* [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.

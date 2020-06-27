# Laravel Soar

> 适配于 laravel 的 SQL 优化器和重写器扩展包。

![CI](https://github.com/guanguans/laravel-soar/workflows/CI/badge.svg?branch=master)

## Installing

``` shell
$ composer require guanguans/laravel-soar --dev -v
```

### publish

```php
$ php artisan vendor:publish --provider="Guanguans\\LaravelSoar\\SoarServiceProvider"
```

## Usage

``` php
echo Guanguans\LaravelSoar\Facades\Soar::htmlExplain('select * from `users` where `id` = 1 limit 1');
// or
echo app('soar')->htmlExplain('select * from `users` where `id` = 1 limit 1');
```

## License

[MIT](LICENSE)

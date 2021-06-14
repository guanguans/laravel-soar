# laravel-soar

> An extension package for optimizing sql statements easily and easily in laravel applications. - 在 Laravel 应用程序中轻松容易的优化 sql 语句的扩展包。

[简体中文](README.md) | [ENGLISH](README-EN.md)

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

``` shell
$ composer require guanguans/laravel-soar --dev -vvv
```

### Publish Configuration

```php
$ php artisan vendor:publish --provider="Guanguans\\LaravelSoar\\SoarServiceProvider"
```

## Usage

### Generate sql scoring report example

``` php
use App\Models\Member;
    
Member::query()
    ->select([
        'id',
        'nickname',
    ])
    ->where('id', 100)
    // ->toSoarScore()
    // ->dumpSoarScore()
    ->ddSoarScore()
;
```

![high-score](./docs/high-score.png)

``` php
// Query builder usage example.
DB::table('yb_member')
    ->select('*')
    ->join('yb_member_account as yb_member_account', 'yb_member_account.member_id', '=', 'yb_member.id')
    ->whereRaw('1 <> 1')
    ->where('yb_member.nickname', 'like', 'admin')
    ->where('yb_member.username', 'like', '%admin%')
    ->whereRaw("substring(yb_member.username, 1, 5) = 'admin'")
    ->whereIn('yb_member.id', [110, 111, 112, 113, 114, 115, 116, 117, 118, 119, 120])
    ->orWhereNotNull('yb_member.realname')
    ->groupByRaw("yb_member.status, '100'")
    ->having('yb_member.id', '>', '100')
    ->orderByRaw('RAND()')
    // ->toSoarScore()   // Generate sql score report.
    // ->dumpSoarScore() // Print sql scoring report.
    ->ddSoarScore()      // Print the sql score report and exit the application.
;
```

![score](./docs/low-score.png)

### Generate an explain information interpretation report example

``` php
// Query builder usage example.
DB::table('yb_member')
    ->select('*')
    ->join('yb_member_account as yb_member_account', 'yb_member_account.member_id', '=', 'yb_member.id')
    ->whereRaw('1 <> 1')
    ->where('yb_member.nickname', 'like', 'admin')
    ->where('yb_member.username', 'like', '%admin%')
    ->whereRaw("substring(yb_member.username, 1, 5) = 'admin'")
    ->whereIn('yb_member.id', [110, 120])
    ->orWhereNotNull('yb_member.realname')
    ->groupByRaw("yb_member.status, '100'")
    ->having('yb_member.id', '>', '100')
    ->orderByRaw('RAND()')
    // ->toSoarHtmlExplain()   // Generate explain information interpretation report.
    // ->dumpSoarHtmlExplain() // Print explain information interpretation report.
    ->ddSoarHtmlExplain()      // Print the explain information interpretation report, and exit the application.
;
```

![explain](./docs/explain.png)

### Beautify sql statemen

``` php
// Query builder usage example.
DB::table('yb_member')
    ->select('*')
    ->join('yb_member_account as yb_member_account', 'yb_member_account.member_id', '=', 'yb_member.id')
    ->whereRaw('1 <> 1')
    ->where('yb_member.nickname', 'like', 'admin')
    ->where('yb_member.username', 'like', '%admin%')
    ->whereRaw("substring(yb_member.username, 1, 5) = 'admin'")
    ->whereIn('yb_member.id', [110, 120])
    ->orWhereNotNull('yb_member.realname')
    ->groupByRaw("yb_member.status, '100'")
    ->having('yb_member.id', '>', '100')
    ->orderByRaw('RAND()')
    // ->toSoarPretty()   // Generate beautified sql.
    // ->dumpSoarPretty() // Print beautified sql.
    ->dumpSoarPretty()    // Print the beautified sql, and exit the application.
;
```

![pretty](./docs/pretty.png)

### Other usage examples

``` php
\Soar::score($sql);        // Generate sql score report.
\Soar::mdExplain($sql);    // Generate explain information interpretation report in markdown format.
\Soar::htmlExplain($sql);  // Generate Explain information interpretation report in html format.
\Soar::syntaxCheck($sql);  // SQL syntax check.
\Soar::fingerPrint($sql);  // Generate sql fingerprint.
\Soar::pretty($sql);       // Beautify sql.
\Soar::md2html($sql);      // Convert markdown format content to html format content.
\Soar::help($sql);         // Output soar help command content.
\Soar::exec($command);     // Execute any soar command.
```

## Testing

``` bash
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

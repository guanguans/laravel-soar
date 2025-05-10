<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpPossiblePolymorphicInvocationInspection */
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection SqlResolve */
/** @noinspection StaticClosureCanBeUsedInspection */
declare(strict_types=1);

/**
 * Copyright (c) 2020-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-soar
 */

use Guanguans\LaravelSoar\Support\Utils;

it('can return star for score', function (): void {
    expect([
        Utils::star(0),
        Utils::star(50),
        Utils::star(100),
    ])->sequence(
        '☆☆☆☆☆',
        '★★★☆☆',
        '★★★★★'
    );
})->group(__DIR__, __FILE__);

it('can sanitize `explain` for `sanitizeExplain`', function (): void {
    $explain = [
        [
            'Item' => 'EXP.000',
            'Severity' => 'L0',
            'Summary' => 'Explain信息',
            'Content' => '| id | select\_type | table | partitions | type | possible_keys | key | key\_len | ref | rows | filtered | scalability | Extra | |---|---|---|---|---|---|---|---|---|---|---|---|---| | 1 | SIMPLE | *NULL* | NULL | NULL | NULL | NULL | NULL | NULL | 0 | 0.00% | NULL | no matching row in const table | ',
            'Case' => '### Explain信息解读 #### SelectType信息解读 * **SIMPLE**: 简单SELECT(不使用UNION或子查询等). #### Extra信息解读 * **no matching row in const table**: 对于连接查询, 列未满足唯一索引的条件或表为空. ',
            'Position' => 0,
        ],
    ];

    expect(Utils::sanitizeExplain($explain))->toBeArray();
})->group(__DIR__, __FILE__);

<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpPossiblePolymorphicInvocationInspection */
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpVoidFunctionResultUsedInspection */
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

use Guanguans\LaravelSoar\Mixins\QueryBuilderMixin;
use Guanguans\LaravelSoar\Outputs\DumpOutput;
use Guanguans\LaravelSoar\Outputs\RayOutput;
use Guanguans\LaravelSoar\Support\Utils;

/**
 * Copyright (c) 2019-2025 guanguans<ityaozm@gmail.com>.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/soar-php
 */
arch('will not use debugging functions')
    // ->throwsNoExceptions()
    ->group(__DIR__, __FILE__)
    ->expect([
        'dd',
        'die',
        'dump',
        'echo',
        'env',
        'env_explode',
        'env_getcsv',
        'exit',
        'print',
        'print_r',
        'printf',
        'ray',
        'trap',
        'var_dump',
        'var_export',
        'vprintf',
    ])
    // ->each
    ->not->toBeUsed()
    ->ignoring([
        DumpOutput::class,
        QueryBuilderMixin::class,
        RayOutput::class,
        Utils::class,
    ]);

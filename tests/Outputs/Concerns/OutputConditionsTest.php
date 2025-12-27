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
 * Copyright (c) 2020-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-soar
 */

use Guanguans\LaravelSoar\Outputs\Concerns\OutputConditions;
use Symfony\Component\HttpFoundation\JsonResponse;

uses(OutputConditions::class);

it('can check is json response for `isJsonResponse`', function (): void {
    expect([
        $this->isJsonResponse(new JsonResponse(data: '', json: true)),
        $this->isJsonResponse(new JsonResponse(data: 'data', json: true)),
    ])->each->toBeFalse();
})->group(__DIR__, __FILE__);

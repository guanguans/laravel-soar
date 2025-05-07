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

use Guanguans\LaravelSoar\Outputs\Concerns\OutputConditions;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

uses(OutputConditions::class);

it('can check is command finished for `isCommandFinished`', function (): void {
    expect($this->isCommandFinished(new Response))->toBeFalse();
})->group(__DIR__, __FILE__);

it('can check is json response for `isJsonResponse`', function (): void {
    expect([
        $this->isJsonResponse(new JsonResponse('', 200, [], true)),
        $this->isJsonResponse(new JsonResponse('data', 200, [], true)),
    ])->each->toBeFalse();
})->group(__DIR__, __FILE__);

<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Tests\Outputs\Concerns;

use Guanguans\LaravelSoar\Outputs\Concerns\OutputConditions;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

uses(OutputConditions::class);

it('can check is command finished for `isCommandFinished`', function (): void {
    expect($this->isCommandFinished(new Response()))->toBeFalse();
})->group(__DIR__, __FILE__);

it('can check is json response for `isJsonResponse`', function (): void {
    expect([
        $this->isJsonResponse(new JsonResponse('', 200, [], true)),
        $this->isJsonResponse(new JsonResponse('data', 200, [], true)),
    ])->each->toBeFalse();
})->group(__DIR__, __FILE__);

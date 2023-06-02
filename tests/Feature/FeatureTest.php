<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Tests\Feature;

it('console output', function (): void {
    $response = $this->get('/html');

    $response->assertSee('console.warn(');
    $response->assertSee('Summary');
    $response->assertSee('HeuristicRules');
    $response->assertSee('IndexRules');
    $response->assertSee('Explain');
    $response->assertSee('Backtraces');
})->group(__DIR__, __FILE__);

it('json output', function (): void {
    $response = $this->get('/json');

    expect($json = $response->getContent())->toBeJson();
    $response->assertSee('soar_scores');
    $response->assertSee('Summary');
    $response->assertSee('HeuristicRules');
    $response->assertSee('IndexRules');
    $response->assertSee('Explain');
    $response->assertSee('Backtraces');
})->group(__DIR__, __FILE__);

it('soar bar output', function (): void {
    $response = $this->get('/html');

    $response->assertSee('background: #efefef url(data:image/svg+xml;base64,');
    $response->assertSee('Summary');
    $response->assertSee('HeuristicRules');
    $response->assertSee('IndexRules');
    $response->assertSee('Explain');
    $response->assertSee('Backtraces');
})->group(__DIR__, __FILE__);

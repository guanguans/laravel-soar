<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Tests;

use Guanguans\LaravelSoar\JavascriptRenderer;
use Pest\Expectation;

it('will dump `AssetsToString` for `dumpAssetsToString`', function (): void {
    expect(['css', 'js'])
        ->each(
            fn (Expectation $item) => expect((fn () => $this->dumpAssetsToString($item->value))->call($this->app->make(JavascriptRenderer::class)))
                ->toBeString()
        );
})->group(__DIR__, __FILE__);

it('will make `UriRelativeTo` for `makeUriRelativeTo`', function (): void {
    expect(['css', 'js'])
        ->each(
            fn (Expectation $item) => expect(
                (fn () => $this->dumpAssetsToString($item->value))->call($this->app->make(JavascriptRenderer::class))
            )->toBeString()
        );
})->group(__DIR__, __FILE__);

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

beforeEach(function (): void {
    $this->javascriptRenderer = $this->app->make(JavascriptRenderer::class);
});

it('can dump assets to string for `dumpAssetsToString`', function (): void {
    $dumpAssetsToString = fn (string $type): string => $this->dumpAssetsToString($type);

    expect([
        $dumpAssetsToString->call($this->javascriptRenderer, 'css'),
        $dumpAssetsToString->call($this->javascriptRenderer, 'js'),
    ])->each->toBeString();
})->group(__DIR__, __FILE__);

it('can get inline html for `getInlineHtml`', function (): void {
    expect($this->javascriptRenderer)
        ->addInlineAssets(
            '<style></style>',
            '<script></script>',
            '<meta charset="utf-8">',
        )
        ->renderHead()->toBeString();
})->group(__DIR__, __FILE__);

it('can make uri relative to for `makeUriRelativeTo`', function (): void {
    $makeUriRelativeTo = fn ($uri, $root): string => $this->makeUriRelativeTo($uri, $root);

    expect([
        $makeUriRelativeTo->call($this->javascriptRenderer, '/', ''),
        $makeUriRelativeTo->call($this->javascriptRenderer, '/', '/'),
    ])->each->toBeString();
})->group(__DIR__, __FILE__);

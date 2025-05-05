<?php

declare(strict_types=1);

/**
 * Copyright (c) 2020-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-soar
 */

namespace Guanguans\LaravelSoarTests;

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

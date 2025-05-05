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

namespace Tests\Feature;

it('can request `assets/javascript`', function (): void {
    $this->get('soar-bar/assets/javascript')
        ->assertOk()
        ->assertHeader('Content-Type', 'text/javascript; charset=UTF-8')
        ->assertSee('jQuery');
})->group(__DIR__, __FILE__);

it('can request `assets/stylesheets`', function (): void {
    $this->get('soar-bar/assets/stylesheets')
        ->assertOk()
        ->assertHeader('Content-Type', 'text/css; charset=UTF-8')
        ->assertSee('Font Awesome');
})->group(__DIR__, __FILE__);

it('can request `fonts/fontawesome-webfont.{suffix}`', function (): void {
    $this->get('soar-bar/fonts/fontawesome-webfont.svg')
        ->assertOk()
        ->assertHeader('Content-Type', 'text/font; charset=UTF-8')
        ->assertSee('svg');
})->group(__DIR__, __FILE__)->skip();

it('can request `fonts/FontAwesome.otf`', function (): void {
    $this->get('soar-bar/fonts/FontAwesome.otf')
        ->assertOk()
        ->assertHeader('Content-Type', 'text/font; charset=UTF-8')
        ->assertSee('name');
})->group(__DIR__, __FILE__)->skip();

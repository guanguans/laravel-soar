<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Illuminate\Support\Facades\Route;

Route::group(
    ['namespace' => 'Guanguans\LaravelSoar\Http\Controllers'] + (array) config('soar.route', [
        'prefix' => 'soar-bar',
        'domain' => null,
        'as' => 'soar.bar.',
        'middleware' => [],
    ]),
    static function ($router): void {
        $router->get('assets/stylesheets', [
            'uses' => 'AssetController@css',
            'as' => 'assets.css',
        ]);

        $router->get('assets/javascript', [
            'uses' => 'AssetController@js',
            'as' => 'assets.js',
        ]);

        $router->get('fonts/fontawesome-webfont.{suffix}', [
            'uses' => 'AssetController@font',
            'as' => 'assets.webfont',
        ]);

        $router->get('fonts/FontAwesome.otf', [
            'uses' => 'AssetController@fontAwesome',
            'as' => 'assets.font',
        ]);
    }
);

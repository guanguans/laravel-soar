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

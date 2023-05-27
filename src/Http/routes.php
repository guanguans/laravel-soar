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

Route::group([
    'namespace' => 'Guanguans\LaravelSoar\Http\Controllers',
    'prefix' => app('config')->get('soar.route_prefix', 'soar-bar'),
    'domain' => app('config')->get('soar.route_domain', null),
    'middleware' => [],
], static function ($router): void {
    $router->get('assets/stylesheets', [
        'uses' => 'AssetController@css',
        'as' => 'soar.bar.assets.css',
    ]);

    $router->get('assets/javascript', [
        'uses' => 'AssetController@js',
        'as' => 'soar.bar.assets.js',
    ]);

    $router->get('fonts/FontAwesome.otf', [
        'uses' => 'AssetController@fontAwesome',
        'as' => 'soar.bar.assets.fontAwesome',
    ]);

    $router->get('fonts/fontawesome-webfont.{suffix}', [
        'uses' => 'AssetController@font',
        'as' => 'soar.bar.assets.font',
    ]);
});

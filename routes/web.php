<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Route::group(
    ['namespace' => 'Guanguans\LaravelSoar\Http\Controllers'] + config('soar.route'),
    static function (Router $router): void {
        $router->get('assets/stylesheets', 'AssetController@css')->name('assets.css');
        $router->get('assets/javascript', 'AssetController@js')->name('assets.js');
        $router->get('fonts/fontawesome-webfont.{suffix}', 'AssetController@font')->name('assets.webfont');
        $router->get('fonts/FontAwesome.otf', 'AssetController@fontAwesome')->name('assets.font');
    }
);

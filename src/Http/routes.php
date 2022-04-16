<?php

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

app('router')->group([
        'namespace' => 'Guanguans\LaravelSoar\Http\Controllers',
        'prefix' => app('config')->get('soar.route_prefix', 'soar-bar'),
        'domain' => app('config')->get('soar.route_domain', null),
        'middleware' => [],
    ], function ($router) {
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
            'uses' => 'AssetController@fonts',
            'as' => 'soar.bar.assets.fonts',
        ]);
    });

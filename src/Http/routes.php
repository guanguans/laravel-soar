<?php

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

$routeOptions = [
    'namespace' => 'Guanguans\LaravelSoar\Http\Controllers',
    'prefix' => app('config')->get('soar.route_prefix', 'soar-debugbar'),
    'domain' => app('config')->get('soar.route_domain', null),
    'middleware' => [],
];

app('router')->group($routeOptions, function ($router) {
    $router->get('assets/stylesheets', [
        'uses' => 'AssetController@css',
        'as' => 'soar.debugbar.assets.css',
    ]);

    $router->get('assets/javascript', [
        'uses' => 'AssetController@js',
        'as' => 'soar.debugbar.assets.js',
    ]);
});

<?php

/** @noinspection LaravelUnknownViewInspection */
/** @noinspection PhpUnusedAliasInspection */
declare(strict_types=1);

/**
 * Copyright (c) 2020-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-soar
 */

use Illuminate\Support\Facades\Route;
use Workbench\App\Support\Utils;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', static fn () => view('welcome'));

Route::get('/', static fn () => view('routes', [
    'routes' => collect(Route::getRoutes()->get('GET'))->filter(
        static fn (Illuminate\Routing\Route $route) => str($route->uri())->endsWith('-example')
    ),
]));

Route::get('general-example', static function (): string {
    Utils::extendOutputManager();

    return Utils::GENERAL_OUTPUT_PHRASE;
});

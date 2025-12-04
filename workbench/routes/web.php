<?php

/** @noinspection PhpUnusedAliasInspection */
/** @noinspection LaravelUnknownViewInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2020-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-soar
 */

use Guanguans\LaravelSoar\OutputManager;
use Guanguans\LaravelSoar\Outputs\JsonOutput;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
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

Route::get('/', static fn () => view('welcome'));

Route::get('/routes', static function () {
    $routes = collect(Route::getRoutes()->get('GET'))->filter(
        static fn (Illuminate\Routing\Route $route) => str($route->uri())->startsWith('output')
    );

    return view('routes', ['routes' => $routes]);
});

Route::group([
    'prefix' => 'output',
    'middleware' => [
        // static function (Request $request, Closure $next): SymfonyResponse {
        //     Utils::extendOutputManager(JsonOutput::class);
        //
        //     return $next($request);
        // },
    ],
], static function (Router $router): void {
    $router->get('all-example', static function (): string {
        Utils::extendOutputManager();

        return OutputManager::class;
    });
    $router->get('json-example', static function (): JsonResponse {
        Utils::extendOutputManager(JsonOutput::class);

        return new JsonResponse(['output' => JsonOutput::class]);
    });
});

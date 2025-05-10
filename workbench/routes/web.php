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

use Guanguans\LaravelSoar\OutputManager;
use Guanguans\LaravelSoar\Outputs\JsonOutput;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;
use Workbench\Database\Factories\UserFactory;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', static fn () => view('welcome'));

Route::get('outputs', static fn () => tap(
    response(OutputManager::class),
    static function (): void {
        extend_output_manager();
        UserFactory::new()->times(3)->create();
    }
));

Route::get('json', static fn () => tap(
    new JsonResponse(JsonOutput::class),
    static function (): void {
        extend_output_manager(JsonOutput::class);
        UserFactory::new()->times(3)->create();
    }
));

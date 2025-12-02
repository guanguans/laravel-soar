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

namespace Workbench\App\Providers;

use Guanguans\LaravelSoar\Facades\Soar;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class WorkbenchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // ...
    }

    /**
     * Bootstrap services.
     */
    public function boot(Request $request): void
    {
        if (str($request->server('DOCUMENT_ROOT'))->contains('vendor/orchestra/testbench-core/laravel/public')) {
            Soar::withSudoPassword('password');
        }
    }
}

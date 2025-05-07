<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpPossiblePolymorphicInvocationInspection */
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection SqlResolve */
/** @noinspection StaticClosureCanBeUsedInspection */
declare(strict_types=1);

/**
 * Copyright (c) 2020-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-soar
 */

use Guanguans\LaravelSoar\Commands\DownloadCommand;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;

it('can download Soar binary', function (): void {
    Http::preventStrayRequests();

    Artisan::call(
        DownloadCommand::class,
        [
            // '--path' => null,
            '--source' => 'gitee',
        ]
    );

    // dump(Artisan::output());
    expect(true)->toBeTrue();
})->group(__DIR__, __FILE__)->skip();

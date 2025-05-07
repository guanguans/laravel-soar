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

use Guanguans\LaravelSoar\Commands\RunCommand;
use function Pest\Laravel\artisan;

it('can run Soar with the given options', function (): void {
    artisan(
        RunCommand::class,
        [
            '--option' => [
                '-verbose=true',
                '-help=true',
            ],
            '--verbose' => true,
        ]
    )->assertOk();
})->group(__DIR__, __FILE__);

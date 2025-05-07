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

use Guanguans\LaravelSoar\Commands\ClearCommand;
use Guanguans\LaravelSoar\Facades\Soar;
use function Pest\Laravel\artisan;

it('can clear the soar log file', function (): void {
    Soar::onlyVerbose()->scores('select * from foo;');

    expect($logFile = ClearCommand::soarLogFile())->toBeFile();

    artisan(ClearCommand::class)
        ->expectsOutput('⏳ Clearing Soar log file...')
        ->expectsOutput("✅ The Soar log file [$logFile] has been cleared.")
        ->assertOk();

    expect($logFile)->not->toBeFile();
})->group(__DIR__, __FILE__);

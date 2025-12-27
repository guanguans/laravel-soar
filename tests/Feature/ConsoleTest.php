<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpPossiblePolymorphicInvocationInspection */
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpVoidFunctionResultUsedInspection */
/** @noinspection SqlResolve */
/** @noinspection StaticClosureCanBeUsedInspection */
declare(strict_types=1);

/**
 * Copyright (c) 2020-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-soar
 */

use Guanguans\LaravelSoar\Bootstrapper;
use Illuminate\Console\Events\CommandFinished;
use Illuminate\Foundation\Testing\WithConsoleEvents;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;
use Workbench\App\Support\Utils;

uses(WithConsoleEvents::class)
    ->beforeEach(function (): void {
        resolve(Bootstrapper::class)->boot();

        $this->see = collect(Arr::first(Soar::arrayScores('select * from users')))
            ->except(['ID', 'Fingerprint'])
            ->keys()
            ->push('Summary', 'Basic', 'Backtraces')
            ->all();
    });

it('is a console not output example', function (): void {
    config()->set('soar.except', ['output:example']);

    $this->artisan('output:example')
        // ->expectsOutput(Utils::CONSOLE_OUTPUT_PHRASE)
        ->expectsOutputToContain(Utils::CONSOLE_OUTPUT_PHRASE)
        ->assertOk();
})->group(__DIR__, __FILE__);

it('is a console output example', function (): void {
    Event::fakeFor(function (): void {
        $this->artisan('output:example')
            // ->expectsOutput(Utils::CONSOLE_OUTPUT_PHRASE)
            ->expectsOutputToContain(Utils::CONSOLE_OUTPUT_PHRASE)
            ->assertOk();

        // Event::assertDispatched(CommandFinished::class);
    });
})->group(__DIR__, __FILE__);

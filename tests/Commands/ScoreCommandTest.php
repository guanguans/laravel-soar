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
 * Copyright (c) 2020-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-soar
 */

use Guanguans\LaravelSoar\Commands\ScoreCommand;
use Symfony\Component\Process\Process;
use function Orchestra\Testbench\php_binary;
use function Pest\Laravel\artisan;

it('can get the Soar scores of the given SQL statements', function (): void {
    artisan(ScoreCommand::class)
        ->expectsQuestion('Please input the SQL statements', 'select * from foo; select * from bar;')
        ->assertOk();
})->group(__DIR__, __FILE__);

it('can get the Soar scores of the given stdin SQL statements', function (): void {
    expect(
        new Process([
            php_binary(),
            __DIR__.'/../../vendor/bin/testbench',
            'soar:score',
        ])
    )
        ->setInput('select * from foo; select * from bar;')
        ->mustRun()
        ->getOutput()
        ->toContain('select * from foo', 'select * from bar');
})->group(__DIR__, __FILE__);

it('can get the Soar scores of the given stdin SQL statements file', function (): void {
    expect(
        Process::fromShellCommandline(str_replace(
            "'<'",
            '<',
            (new Process(
                command: [
                    php_binary(),
                    __DIR__.'/../../vendor/bin/testbench',
                    'soar:score',
                    '<',
                    fixtures_path('queries.sql'),
                ],
            ))->getCommandLine()
        ))
    )
        ->mustRun()
        ->getOutput()
        ->toContain('select * from foo', 'select * from bar');
})->group(__DIR__, __FILE__);

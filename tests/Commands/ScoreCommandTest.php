<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Tests\Facades;

use Guanguans\LaravelSoar\Commands\ScoreCommand;
use Symfony\Component\Console\Command\Command;

use function Pest\Laravel\artisan;

it('can get the Soar scores of the given SQL statements', function (): void {
    artisan(ScoreCommand::class)
        ->expectsQuestion('Please input the SQL statements', 'select * from foo; select * from bar;')
        ->assertExitCode(Command::SUCCESS);
})->group(__DIR__, __FILE__);

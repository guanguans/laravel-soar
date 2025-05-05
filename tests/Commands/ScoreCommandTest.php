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

namespace Guanguans\LaravelSoarTests\Facades;

use Guanguans\LaravelSoar\Commands\ScoreCommand;
use Symfony\Component\Console\Command\Command;
use function Pest\Laravel\artisan;

it('can get the Soar scores of the given SQL statements', function (): void {
    artisan(ScoreCommand::class)
        ->expectsQuestion('Please input the SQL statements', 'select * from foo; select * from bar;')
        ->assertExitCode(Command::SUCCESS);
})->group(__DIR__, __FILE__);

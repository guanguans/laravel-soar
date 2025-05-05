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

use Guanguans\LaravelSoar\Commands\ClearCommand;
use Guanguans\LaravelSoar\Facades\Soar;
use Symfony\Component\Console\Command\Command;
use function Pest\Laravel\artisan;

it('can clear the Soar log file', function (): void {
    Soar::onlyVerbose()->scores('select * from foo');
    $logFile = Soar::getOption('-log-output', \dirname(Soar::getSoarBinary()).\DIRECTORY_SEPARATOR.'soar.log');

    expect($logFile)->toBeFile();
    artisan(ClearCommand::class)->expectsOutput('Clearing Soar log file...')->assertExitCode(Command::SUCCESS);
    expect($logFile)->not->toBeFile();
})->group(__DIR__, __FILE__);

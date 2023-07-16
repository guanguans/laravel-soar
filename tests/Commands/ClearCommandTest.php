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

use Guanguans\LaravelSoar\Commands\ClearCommand;
use Guanguans\LaravelSoar\Facades\Soar;

use function Pest\Laravel\artisan;

it('can clear the Soar log file', function (): void {
    Soar::onlyVerbose()->scores('select * from foo');
    $logFile = Soar::getLogOutput(\dirname(Soar::getSoarPath()).\DIRECTORY_SEPARATOR.'soar.log');

    expect($logFile)->toBeFile();
    artisan(ClearCommand::class)->expectsOutput('Clearing Soar log file...')->assertSuccessful();
    expect($logFile)->not->toBeFile();
})->group(__DIR__, __FILE__);

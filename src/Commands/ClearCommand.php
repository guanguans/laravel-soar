<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelSoar\Commands;

use Guanguans\LaravelSoar\Facades\Soar;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ClearCommand extends Command
{
    protected $signature = 'soar:clear';

    protected $description = 'Clear the Soar log file';

    public function handle(): void
    {
        $this->info('Clearing Soar log file...');

        File::delete($logFile = Soar::getLogOutput(\dirname(Soar::getSoarBinary()).\DIRECTORY_SEPARATOR.'soar.log'));

        $this->info("The Soar log file($logFile) has been cleared.");
    }
}

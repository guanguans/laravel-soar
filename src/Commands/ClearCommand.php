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

namespace Guanguans\LaravelSoar\Commands;

use Guanguans\LaravelSoar\Facades\Soar;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ClearCommand extends Command
{
    /** @noinspection ClassOverridesFieldOfSuperClassInspection */
    protected $signature = 'soar:clear';

    /** @noinspection ClassOverridesFieldOfSuperClassInspection */
    protected $description = 'Clear the Soar log file';

    public function handle(): void
    {
        $this->info('⏳ Clearing Soar log file...');

        File::delete($logFile = self::soarLogFile());

        $this->info("✅ The Soar log file [$logFile] has been cleared.");
    }

    public static function soarLogFile(): string
    {
        return Soar::getLogOutput(\dirname(Soar::getBinary()).\DIRECTORY_SEPARATOR.'soar.log');
    }
}

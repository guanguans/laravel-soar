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

use Guanguans\LaravelSoar\Soar;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Symfony\Component\Console\Helper\ProgressBar;

/**
 * @method defaultSoarBinary()
 */
class DownloadCommand extends Command
{
    private const SOURCES = [
        'github' => 'https://raw.githubusercontent.com/guanguans/soar-php/master/bin/%s',
        'gitee' => 'https://gitee.com/guanguans/soar-php/raw/master/bin/%s',
    ];

    /** @noinspection ClassOverridesFieldOfSuperClassInspection */
    protected $signature = <<<'SIGNATURE'
        soar:download
        {--s|source=github : The source of the Soar binary.}
        {--p|path= : The saved path of the Soar binary.}
        SIGNATURE;

    /** @noinspection ClassOverridesFieldOfSuperClassInspection */
    protected $description = 'Download the Soar binary';

    public function handle(): void
    {
        $savedPath = $this->savedPath();

        if (File::isFile($savedPath)) {
            $this->warn("⚠️ The Soar binary [$savedPath] already exists.");

            return;
        }

        $this->info('⏳ Downloading Soar binary...');

        Http::withoutVerifying()
            ->withOptions([
                'sink' => $savedPath,
                'progress' => function (int $totalDownload, int $downloaded) use (&$progressBar): void {
                    if (0 < $totalDownload && 0 < $downloaded && !$progressBar instanceof ProgressBar) {
                        $progressBar = new ProgressBar($this->output, $totalDownload);
                        $progressBar->start();
                    }

                    if ($totalDownload === $downloaded && $progressBar instanceof ProgressBar) {
                        $progressBar->finish();
                    }

                    $progressBar and $progressBar->setProgress($downloaded);
                },
            ])
            ->get($this->url());

        $this->info("✅ The Soar binary [$savedPath] has been downloaded.");
    }

    private function soarBinaryName(): string
    {
        return basename((fn () => $this->defaultSoarBinary())->call(resolve(Soar::class)));
    }

    /**
     * @noinspection OffsetOperationsInspection
     */
    private function url(): string
    {
        return \sprintf(self::SOURCES[$this->option('source')], $this->soarBinaryName());
    }

    private function savedPath(): string
    {
        return $this->option('path') ?: base_path($this->soarBinaryName());
    }
}

<?php

/** @noinspection PhpUnusedAliasInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2020-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-soar
 */

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Number;
use Spatie\ImageOptimizer\OptimizerChain;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Workbench\App\Support\Utils;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

// Artisan::command('inspire', function () {
//     $this->components->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote');

Artisan::command('output:example', function (): void {
    Utils::extendOutputManager();

    /** @var \Illuminate\Console\Command $this */
    $this->components->info(Utils::CONSOLE_OUTPUT_PHRASE);
});

Artisan::command('public:link', function (): void {
    Utils::links([
        __DIR__.'/../'.basename($target = __DIR__.'/../../vendor/orchestra/testbench-core/laravel/public/') => $target,
    ]);

    /** @var \Illuminate\Console\Command $this */
    $this->components->info('The [public] directory has been linked.');
});

Artisan::command('optimize:image {--dry-run : Only list found images}', function (): void {
    $imagesFinder = static fn (): Collection => collect(
        Finder::create()
            ->in(getcwd())
            ->exclude([
                'Fixtures/',
                'vendor-bin/',
            ])
            ->name([
                '/\.jpg$/',
                '/\.jpeg$/',
                '/\.png$/',
                '/\.gif$/',
                '/\.webp$/',
                '/\.svg$/',
                '/\.avif$/',
            ])
            ->ignoreDotFiles(false)
            ->ignoreUnreadableDirs(false)
            ->ignoreVCS(true)
            ->ignoreVCSIgnored(true)
            ->files()
    )->map(static fn (SplFileInfo $image): array => [
        'size' => $image->getSize(),
        'human_size' => Number::fileSize($image->getSize()),
        'real_path' => $image->getRealPath(),
    ]);

    /** @var \Illuminate\Console\Command $this */
    if ($this->option('dry-run')) {
        $imagesFinder()
            ->tap(function (Collection $images): void {
                $this->components->info("Found {$images->count()} images:");
            })
            ->each(function (array $image): void {
                $this->components->twoColumnDetail($image['real_path'], $image['human_size']);
            });

        return;
    }

    $imagesFinder()
        ->tap(function (Collection $images): void {
            $this->components->info("Optimizing {$images->count()} images:");
        })
        ->each(function (array $image): void {
            $this->components->task(
                $image['real_path'],
                static fn () => resolve(OptimizerChain::class)->useLogger(Log::channel())->optimize($image['real_path'])
            );
        })
        ->tap(function (Collection $images): void {
            $this->components->info("Optimization results for {$images->count()} images:");
        })
        ->tap(function (Collection $images) use ($imagesFinder): void {
            $imagesFinder()->each(function (array $fileInfo, string $file) use ($images): void {
                $originalSize = $images->get($file)['size'];
                $percentage = 0 < $originalSize
                    // ? \sprintf('(%.2f%%)', ($originalSize - $fileInfo['size']) / $originalSize * 100)
                    ? Number::percentage(abs($originalSize - $fileInfo['size']) / $originalSize * 100, 1)
                    : '0.0%';
                $this->components->twoColumnDetail(
                    $file,
                    "{$images->get($file)['human_size']} -> {$fileInfo['human_size']} ($percentage)"
                );
            });
        });
});

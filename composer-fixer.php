#!/usr/bin/env php
<?php
declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\Process;

require __DIR__.'/vendor/autoload.php';

/** @noinspection JsonEncodingApiUsageInspection */
$composerJson = json_decode(file_get_contents(__DIR__.'/composer.json'), true);
$symfonyStyle = new SymfonyStyle(new ArgvInput(), new ConsoleOutput());

foreach ($composerJson as $option => $value) {
    if (! in_array($option, ['require', 'require-dev'], true)) {
        continue;
    }

    foreach ($value as $package => $version) {
        if (
            'php' === $package
            || '*' === $version
            || str_starts_with($package, 'ext-')
            || str_starts_with($version, 'dev-')
            || str_contains($version, '|')
        ) {
            continue;
        }

        $symfonyStyle->warning("Fixing $option $package ...");

        try {
            Process::fromShellCommandline(sprintf(
                'COMPOSER_MEMORY_LIMIT=-1 %s %s require %s %s --ansi -W -v',
                (new PhpExecutableFinder())->find(),
                (new Symfony\Component\Process\ExecutableFinder())->find('composer'),
                $package,
                'require-dev' === $option ? '--dev' : ''
            ))->mustRun(static function ($type, $buffer) use ($symfonyStyle): void {
                $symfonyStyle->write($buffer);
            });

            $symfonyStyle->warning("Fixing $option $package success.");
        } catch (ProcessFailedException $e) {
            $symfonyStyle->error("Fixing $option $package failed.");
        }
    }
}

$symfonyStyle->success('All done.');

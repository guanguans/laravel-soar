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

namespace Workbench\App\Support;

use Guanguans\LaravelSoar\OutputManager;
use Guanguans\LaravelSoar\Outputs\ClockworkOutput;
use Guanguans\LaravelSoar\Outputs\ConsoleOutput;
use Guanguans\LaravelSoar\Outputs\DebugBarOutput;
use Guanguans\LaravelSoar\Outputs\DumpOutput;
use Guanguans\LaravelSoar\Outputs\JsonOutput;
use Guanguans\LaravelSoar\Outputs\LaraDumpsOutput;
use Guanguans\LaravelSoar\Outputs\LogOutput;
use Guanguans\LaravelSoar\Outputs\RayOutput;
use Illuminate\Support\Facades\Artisan;
use Workbench\App\Models\User;
use Workbench\Database\Factories\UserFactory;

class Utils
{
    public const CONSOLE_OUTPUT_PHRASE = 'This is a console output example.';
    public const GENERAL_OUTPUT_PHRASE = 'This is a general output example.';
    public const JSON_OUTPUT_PHRASE = 'This is a json output example.';

    public static function extendOutputManager(null|array|string $outputs = null): void
    {
        $outputs ??= [
            ClockworkOutput::class,
            ConsoleOutput::class => ['method' => 'warn'],
            DebugBarOutput::class => ['name' => 'Soar Scores', 'label' => 'warning'],
            DumpOutput::class => ['exit' => false],
            JsonOutput::class => ['key' => 'soar_scores'],
            LaraDumpsOutput::class => ['label' => 'Soar Scores'],
            LogOutput::class => ['channel' => 'daily', 'level' => 'warning'],
            RayOutput::class => ['label' => 'Soar Scores'],
        ];

        app()->extend(
            OutputManager::class,
            static function (OutputManager $outputManager) use ($outputs): OutputManager {
                foreach ((array) $outputs as $class => $parameters) {
                    if (!\is_array($parameters)) {
                        [$parameters, $class] = [(array) $class, $parameters];
                    }

                    $outputManager[$class] = resolve($class, $parameters);
                }

                return $outputManager;
            }
        );

        UserFactory::new()->times(3)->create();
        User::query()->first();
    }

    /**
     * @see \Illuminate\Foundation\Console\StorageLinkCommand
     */
    public static function links(array $links, array $parameters = []): int
    {
        $originalLinks = config('filesystems.links', []);

        config()->set('filesystems.links', $links);

        $status = Artisan::call('storage:link', $parameters + [
            '--ansi' => true,
            '--verbose' => true,
        ]);

        config()->set('filesystems.links', $originalLinks);

        // echo Artisan::output();

        return $status;
    }
}

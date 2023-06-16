<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Tests;

use Barryvdh\Debugbar\ServiceProvider;
use Clockwork\Support\Laravel\ClockworkServiceProvider;
use Guanguans\LaravelSoar\OutputManager;
use Guanguans\LaravelSoar\Outputs\ClockworkOutput;
use Guanguans\LaravelSoar\Outputs\ConsoleOutput;
use Guanguans\LaravelSoar\Outputs\DebugBarOutput;
use Guanguans\LaravelSoar\Outputs\DumpOutput;
use Guanguans\LaravelSoar\Outputs\ErrorLogOutput;
use Guanguans\LaravelSoar\Outputs\JsonOutput;
use Guanguans\LaravelSoar\Outputs\LogOutput;
use Guanguans\LaravelSoar\Outputs\NullOutput;
use Guanguans\LaravelSoar\Outputs\RayOutput;
use Guanguans\LaravelSoar\Outputs\SoarBarOutput;
use Guanguans\LaravelSoar\Outputs\SyslogOutput;
use Guanguans\LaravelSoar\SoarServiceProvider;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use phpmock\phpunit\PHPMock;
use Spatie\Snapshots\MatchesSnapshots;
use Symfony\Component\VarDumper\Test\VarDumperTestTrait;
use Tests\Models\User;
use Tests\Seeder\UserSeeder;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    use MatchesSnapshots;
    use PHPMock;
    use VarDumperTestTrait;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpDatabase();
        $this->withFactories(__DIR__.'/Factories/');
        $this->seed(UserSeeder::class);
    }

    protected function getPackageProviders($app)
    {
        return [
            SoarServiceProvider::class,
            ClockworkServiceProvider::class,
            ServiceProvider::class,
        ];
    }

    /**
     * {@inheritDoc}
     */
    protected function defineEnvironment($app): void
    {
        config()->set('soar', require __DIR__.'/../config/soar.php');
        config()->set('soar.enabled', true);
        config()->set('soar.outputs', [
            // ClockworkOutput::class,
            // ConsoleOutput::class => ['method' => 'warn'],
            // DebugBarOutput::class => ['name' => 'Soar Scores', 'label' => 'warning'],
            // DumpOutput::class => ['exit' => false],
            // ErrorLogOutput::class => ['messageType' => 0, 'destination' => '', 'extraHeaders' => ''],
            // JsonOutput::class => ['key' => 'soar_scores'],
            // LogOutput::class => ['channel' => 'daily', 'level' => 'warning'],
            // NullOutput::class,
            // RayOutput::class => ['label' => 'Soar Scores'],
            // SoarBarOutput::class => ['name' => 'Scores', 'label' => 'warning'],
            // SyslogOutput::class => ['priority' => LOG_WARNING],
        ]);
        config()->set('soar.options.-test-dsn.disable', true);
        config()->set('soar.options.-online-dsn.disable', true);

        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        config()->set('app.key', 'base64:6Cu/ozj4gPtIjmXjr8EdVnGFNsdRqZfHfVjQkmTlg4Y=');
    }

    protected function setUpDatabase(): void
    {
        $this->app['db']->connection()->getSchemaBuilder()->create('users', static function (Blueprint $blueprint): void {
            $blueprint->bigIncrements('id');
            $blueprint->string('name');
            $blueprint->string('email')->unique();
            $blueprint->timestamp('email_verified_at')->nullable();
            $blueprint->string('password');
            $blueprint->rememberToken();
            $blueprint->timestamps();
        });
    }

    /**
     * {@inheritDoc}
     *
     * @noinspection PhpUndefinedMethodInspection
     * @noinspection PhpUndefinedFieldInspection
     */
    protected function defineRoutes($router): void
    {
        $query = static function (): void {
            User::query()->create([
                'name' => 'soar',
                'email' => 'soar@soar.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
            ]);
        };

        Artisan::command('outputs', function () use ($query): void {
            $this->laravel->extend(OutputManager::class, function (OutputManager $outputManager): OutputManager {
                foreach (
                    [
                        ClockworkOutput::class,
                        ConsoleOutput::class => ['method' => 'warn'],
                        DebugBarOutput::class => ['name' => 'Soar Scores', 'label' => 'warning'],
                        DumpOutput::class => ['exit' => false],
                        ErrorLogOutput::class => ['messageType' => 0, 'destination' => '', 'extraHeaders' => ''],
                        JsonOutput::class => ['key' => 'soar_scores'],
                        LogOutput::class => ['channel' => 'daily', 'level' => 'warning'],
                        NullOutput::class,
                        RayOutput::class => ['label' => 'Soar Scores'],
                        SoarBarOutput::class => ['name' => 'Scores', 'label' => 'warning'],
                        SyslogOutput::class => ['priority' => LOG_WARNING],
                    ] as $class => $parameters
                ) {
                    if (! \is_array($parameters)) {
                        [$parameters, $class] = [$class, $parameters];
                    }

                    $outputManager[$class] = $this->laravel->make($class, (array) $parameters);
                }

                return $outputManager;
            });
            $query();

            $this->info(OutputManager::class);
        });

        Route::get('outputs', fn () => tap(response(OutputManager::class), function () use ($query): void {
            $this->app->extend(OutputManager::class, function (OutputManager $outputManager): OutputManager {
                foreach (
                    [
                        ClockworkOutput::class,
                        ConsoleOutput::class => ['method' => 'warn'],
                        DebugBarOutput::class => ['name' => 'Soar Scores', 'label' => 'warning'],
                        DumpOutput::class => ['exit' => false],
                        ErrorLogOutput::class => ['messageType' => 0, 'destination' => '', 'extraHeaders' => ''],
                        JsonOutput::class => ['key' => 'soar_scores'],
                        LogOutput::class => ['channel' => 'daily', 'level' => 'warning'],
                        NullOutput::class,
                        RayOutput::class => ['label' => 'Soar Scores'],
                        SoarBarOutput::class => ['name' => 'Scores', 'label' => 'warning'],
                        SyslogOutput::class => ['priority' => LOG_WARNING],
                    ] as $class => $parameters
                ) {
                    if (! \is_array($parameters)) {
                        [$parameters, $class] = [$class, $parameters];
                    }

                    $outputManager[$class] = $this->app->make($class, (array) $parameters);
                }

                return $outputManager;
            });
            $query();
        }));

        Route::get('json', fn () => tap(response()->json(JsonOutput::class), function () use ($query): void {
            $this->app->extend(OutputManager::class, function (OutputManager $outputManager): OutputManager {
                $outputManager[JsonOutput::class] = $this->app->make(JsonOutput::class);

                return $outputManager;
            });
            $query();
        }));

        Route::get('soar-bar', fn () => tap(response(SoarBarOutput::class), function () use ($query): void {
            $this->app->extend(OutputManager::class, function (OutputManager $outputManager): OutputManager {
                $outputManager[SoarBarOutput::class] = $this->app->make(SoarBarOutput::class);

                return $outputManager;
            });
            $query();
            (function (): void {
                $this::$outputted = false;
            })->call($this->app->make(DebugBarOutput::class));
        }));
    }
}

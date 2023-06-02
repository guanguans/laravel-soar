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
use Guanguans\LaravelSoar\Outputs\ClockworkOutput;
use Guanguans\LaravelSoar\Outputs\ConsoleOutput;
use Guanguans\LaravelSoar\Outputs\DebugBarOutput;
use Guanguans\LaravelSoar\Outputs\DumpOutput;
use Guanguans\LaravelSoar\Outputs\JsonOutput;
use Guanguans\LaravelSoar\Outputs\LogOutput;
use Guanguans\LaravelSoar\Outputs\NullOutput;
use Guanguans\LaravelSoar\Outputs\SoarBarOutput;
use Guanguans\LaravelSoar\SoarServiceProvider;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Tests\Models\User;
use Tests\Seeder\UserSeeder;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
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
    protected function getEnvironmentSetUp($app): void
    {
        config()->set('soar', require __DIR__.'/../config/soar.php');
        config()->set('soar.enabled', true);
        config()->set('soar.outputs', [
            // \Guanguans\LaravelSoar\Outputs\ClockworkOutput::class,
            // \Guanguans\LaravelSoar\Outputs\ConsoleOutput::class,
            // \Guanguans\LaravelSoar\Outputs\DebugBarOutput::class,
            // \Guanguans\LaravelSoar\Outputs\DumpOutput::class => ['exit' => false],
            // \Guanguans\LaravelSoar\Outputs\JsonOutput::class,
            // \Guanguans\LaravelSoar\Outputs\LogOutput::class => ['channel' => 'daily'],
            // \Guanguans\LaravelSoar\Outputs\NullOutput::class,
            // \Guanguans\LaravelSoar\Outputs\SoarBarOutput::class,
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

        Route::get('clockwork', static function () use ($query) {
            return tap(response(ClockworkOutput::class), function () use ($query): void {
                config()->set('soar.outputs', [
                    \Guanguans\LaravelSoar\Outputs\ClockworkOutput::class,
                    // \Guanguans\LaravelSoar\Outputs\ConsoleOutput::class,
                    // \Guanguans\LaravelSoar\Outputs\DebugBarOutput::class,
                    // \Guanguans\LaravelSoar\Outputs\DumpOutput::class => ['exit' => false],
                    // \Guanguans\LaravelSoar\Outputs\JsonOutput::class,
                    // \Guanguans\LaravelSoar\Outputs\LogOutput::class => ['channel' => 'daily'],
                    // \Guanguans\LaravelSoar\Outputs\NullOutput::class,
                    // \Guanguans\LaravelSoar\Outputs\SoarBarOutput::class,
                ]);
                $query();
            });
        });

        Route::get('console', static function () use ($query) {
            return tap(response(ConsoleOutput::class), function () use ($query): void {
                config()->set('soar.outputs', [
                    // \Guanguans\LaravelSoar\Outputs\ClockworkOutput::class,
                    \Guanguans\LaravelSoar\Outputs\ConsoleOutput::class,
                    // \Guanguans\LaravelSoar\Outputs\DebugBarOutput::class,
                    // \Guanguans\LaravelSoar\Outputs\DumpOutput::class => ['exit' => false],
                    // \Guanguans\LaravelSoar\Outputs\JsonOutput::class,
                    // \Guanguans\LaravelSoar\Outputs\LogOutput::class => ['channel' => 'daily'],
                    // \Guanguans\LaravelSoar\Outputs\NullOutput::class,
                    // \Guanguans\LaravelSoar\Outputs\SoarBarOutput::class,
                ]);
                $query();
            });
        });

        Route::get('debug-bar', static function () use ($query) {
            return tap(response(DebugBarOutput::class), function () use ($query): void {
                $query();
            });
        });

        Route::get('dump', static function () use ($query) {
            return tap(response(DumpOutput::class), function () use ($query): void {
                $query();
            });
        });

        Route::get('json', static function () use ($query) {
            return tap(response()->json(JsonOutput::class), function () use ($query): void {
                config()->set('soar.outputs', [
                    // \Guanguans\LaravelSoar\Outputs\ClockworkOutput::class,
                    // \Guanguans\LaravelSoar\Outputs\ConsoleOutput::class,
                    // \Guanguans\LaravelSoar\Outputs\DebugBarOutput::class,
                    // \Guanguans\LaravelSoar\Outputs\DumpOutput::class => ['exit' => false],
                    \Guanguans\LaravelSoar\Outputs\JsonOutput::class,
                    // \Guanguans\LaravelSoar\Outputs\LogOutput::class => ['channel' => 'daily'],
                    // \Guanguans\LaravelSoar\Outputs\NullOutput::class,
                    // \Guanguans\LaravelSoar\Outputs\SoarBarOutput::class,
                ]);
                $query();
            });
        });

        Route::get('log', static function () use ($query) {
            return tap(response(LogOutput::class), function () use ($query): void {
                $query();
            });
        });

        Route::get('null', static function () use ($query) {
            return tap(response(NullOutput::class), function () use ($query): void {
                $query();
            });
        });

        Route::get('soar-bar', static function () use ($query) {
            return tap(response(SoarBarOutput::class), function () use ($query): void {
                $query();
            });
        });
    }
}

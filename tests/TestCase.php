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
use Guanguans\LaravelSoar\SoarServiceProvider;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Tests\Models\User;
use Tests\Seeder\TestSeeder;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpDatabase();
        $this->withFactories(__DIR__.'/Factories/');
        $this->seed(TestSeeder::class);
        $this->setUpApplicationRoutes();
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
        config()->set('soar.output', [
            \Guanguans\LaravelSoar\Outputs\ClockworkOutput::class,
            \Guanguans\LaravelSoar\Outputs\ConsoleOutput::class,
            \Guanguans\LaravelSoar\Outputs\DumpOutput::class => ['exit' => false],
            \Guanguans\LaravelSoar\Outputs\JsonOutput::class,
            \Guanguans\LaravelSoar\Outputs\LogOutput::class => ['channel' => 'daily'],
            \Guanguans\LaravelSoar\Outputs\DebugBarOutput::class,
            \Guanguans\LaravelSoar\Outputs\SoarBarOutput::class,
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
        Route::get('/json', static function (): JsonResponse {
            DB::select('create table "user" ("id" integer not null primary key autoincrement, "name" varchar not null, "email" varchar not null, "email_verifie_at" datetime, "password" varchar not null, "remember_token" varchar, "created_at" datetime, "updated_at" datetime)');

            User::query()->insert([
                'name' => 'soar',
                'email' => 'soar@soar.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
            ]);

            User::query()->where('id', 1)->delete();

            User::query()->where('id', 2)->update([
                'email_verified_at' => now(),
                'password' => Str::random(32),
                'remember_token' => Str::random(10),
            ]);

            User::query()->where('name', 'soar')->groupBy('name')->orderBy('name')->first();

            return response()->json('This is a json response.');
        });

        Route::get('/html', static function () {
            DB::select('create table "user" ("id" integer not null primary key autoincrement, "name" varchar not null, "email" varchar not null, "email_verifie_at" datetime, "password" varchar not null, "remember_token" varchar, "created_at" datetime, "updated_at" datetime)');

            User::query()->insert([
                'name' => 'soar',
                'email' => 'soar@soar.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
            ]);

            User::query()->where('id', 1)->delete();

            User::query()->where('id', 2)->update([
                'email_verified_at' => now(),
                'password' => Str::random(32),
                'remember_token' => Str::random(10),
            ]);

            User::query()->where('name', 'soar')->groupBy('name')->orderBy('name')->first();

            return response('This is a html response.');
        });
    }
}

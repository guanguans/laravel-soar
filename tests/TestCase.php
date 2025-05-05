<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpPossiblePolymorphicInvocationInspection */
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection StaticClosureCanBeUsedInspection */
declare(strict_types=1);

/**
 * Copyright (c) 2020-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-soar
 */

namespace Guanguans\LaravelSoarTests;

use Barryvdh\Debugbar\ServiceProvider;
use Clockwork\Support\Laravel\ClockworkServiceProvider;
use Guanguans\LaravelSoar\Facades\Soar;
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
use Guanguans\LaravelSoarTests\Models\User;
use Guanguans\LaravelSoarTests\Seeder\UserSeeder;
use Illuminate\Database\ConnectionResolverInterface;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use phpmock\phpunit\PHPMock;
use Spatie\Snapshots\MatchesSnapshots;
use Symfony\Component\VarDumper\Test\VarDumperTestTrait;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    use Faker;
    use MatchesSnapshots;
    use MockeryPHPUnitIntegration;
    use PHPMock;
    use VarDumperTestTrait;
    public const OUTPUTS = [
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
        SyslogOutput::class => ['priority' => \LOG_WARNING],
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->startMockery();
        $this->setUpDatabase();
        $this->withFactories(__DIR__.'/Factories/');
        $this->seed(UserSeeder::class);
    }

    protected function tearDown(): void
    {
        $this->closeMockery();
        parent::tearDown();
    }

    /**
     * @param array<class-string, array<string, mixed>>|class-string|list<class-string> $outputs
     */
    final public static function extendOutputManagerWithOutputs($outputs): void
    {
        app()->extend(OutputManager::class, static function (OutputManager $outputManager) use ($outputs): OutputManager {
            foreach ((array) $outputs as $class => $parameters) {
                if (!\is_array($parameters)) {
                    [$parameters, $class] = [(array) $class, $parameters];
                }

                $outputManager[$class] = app($class, $parameters);
            }

            return $outputManager;
        });
    }

    protected function getPackageProviders($app)
    {
        return [
            SoarServiceProvider::class,
            ClockworkServiceProvider::class,
            ServiceProvider::class,
            ...parent::getPackageProviders($app),
        ];
    }

    protected function getPackageAliases($app): array
    {
        return [
            'Soar' => Soar::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        config()->set('app.key', 'base64:6Cu/ozj4gPtIjmXjr8EdVnGFNsdRqZfHfVjQkmTlg4Y=');

        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        config()->set('soar.enabled', true);
        config()->set('soar.outputs', []);
        config()->set('soar.options.-test-dsn.disable', true);
        config()->set('soar.options.-online-dsn.disable', true);
    }

    protected function setUpDatabase(): void
    {
        $this->app->make(ConnectionResolverInterface::class)
            ->connection()
            ->getSchemaBuilder()
            ->create('users', static function (Blueprint $blueprint): void {
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
     * @noinspection PhpUndefinedMethodInspection
     * @noinspection PhpUndefinedFieldInspection
     */
    protected function defineRoutes(mixed $router): void
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
            TestCase::extendOutputManagerWithOutputs(TestCase::OUTPUTS);

            $query();

            $this->info(OutputManager::class);
        });

        Route::get('outputs', static fn () => tap(response(OutputManager::class), function () use ($query): void {
            self::extendOutputManagerWithOutputs(self::OUTPUTS);

            $query();
        }));

        Route::get('json', static fn () => tap(new JsonResponse(JsonOutput::class), function () use ($query): void {
            self::extendOutputManagerWithOutputs(JsonOutput::class);

            $query();
        }));

        Route::get('soar-bar', fn () => tap(response(SoarBarOutput::class), function () use ($query): void {
            self::extendOutputManagerWithOutputs(SoarBarOutput::class);

            $query();

            (function (): void {
                $this::$outputted = false;
            })->call($this->app->make(DebugBarOutput::class));
        }));
    }
}

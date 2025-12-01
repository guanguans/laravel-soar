<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpPossiblePolymorphicInvocationInspection */
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpVoidFunctionResultUsedInspection */
/** @noinspection SqlResolve */
/** @noinspection StaticClosureCanBeUsedInspection */
/** @noinspection PhpInconsistentReturnPointsInspection */
/** @noinspection PhpInternalEntityUsedInspection */
/** @noinspection PhpUnused */
declare(strict_types=1);

/**
 * Copyright (c) 2020-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-soar
 */

use Faker\Factory;
use Guanguans\LaravelSoar\OutputManager;
use Guanguans\LaravelSoar\Outputs\ClockworkOutput;
use Guanguans\LaravelSoar\Outputs\ConsoleOutput;
use Guanguans\LaravelSoar\Outputs\DebugBarOutput;
use Guanguans\LaravelSoar\Outputs\DumpOutput;
use Guanguans\LaravelSoar\Outputs\JsonOutput;
use Guanguans\LaravelSoar\Outputs\LaraDumpsOutput;
use Guanguans\LaravelSoar\Outputs\LogOutput;
use Guanguans\LaravelSoar\Outputs\RayOutput;
use Guanguans\LaravelSoarTests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Pest\Expectation;
use Workbench\App\Models\User;
use Workbench\Database\Factories\UserFactory;

uses(TestCase::class)
    // ->compact()
    ->beforeAll(function (): void {})
    ->beforeEach(function (): void {
        links([
            __DIR__.'/../'.basename($target = __DIR__.'/../vendor/orchestra/testbench-core/laravel') => $target,
        ]);

        /** @var \Guanguans\LaravelSoarTests\TestCase $this */
        $this->defineEnvironment(app());
    })
    ->afterEach(function (): void {})
    ->afterAll(function (): void {})
    ->in(
        __DIR__,
        // __DIR__.'/Arch/',
        // __DIR__.'/Feature/',
        // __DIR__.'/Integration/',
        // __DIR__.'/Unit/'
    );

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
 */

/**
 * @see expect()->toBetween()
 */
expect()->extend(
    'toAssert',
    function (Closure $assertions): Expectation {
        $assertions($this->value);

        return $this;
    }
);

/**
 * @see Expectation::toBeBetween()
 */
expect()->extend(
    'toBetween',
    fn (int $min, int $max): Expectation => expect($this->value)
        ->toBeGreaterThanOrEqual($min)
        ->toBeLessThanOrEqual($max)
);

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
 */

/**
 * @throws ReflectionException
 */
function class_namespace(object|string $class): string
{
    $class = \is_object($class) ? $class::class : $class;

    return (new ReflectionClass($class))->getNamespaceName();
}

function fixtures_path(string $path = ''): string
{
    return __DIR__.\DIRECTORY_SEPARATOR.'Fixtures'.($path ? \DIRECTORY_SEPARATOR.$path : $path);
}

if (!\function_exists('fake')) {
    /**
     * @see https://github.com/laravel/framework/blob/12.x/src/Illuminate/Foundation/helpers.php#L515
     */
    function fake(string $locale = Factory::DEFAULT_LOCALE): Generator
    {
        return Factory::create($locale);
    }
}

function running_in_github_action(): bool
{
    return getenv('GITHUB_ACTIONS') === 'true';
}

/**
 * @see \Illuminate\Foundation\Console\StorageLinkCommand
 */
function links(array $links, array $parameters = []): int
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

function extend_output_manager(null|array|string $outputs = null): void
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

<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpPossiblePolymorphicInvocationInspection */
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection StaticClosureCanBeUsedInspection */
/** @noinspection PhpInconsistentReturnPointsInspection */
/** @noinspection PhpInternalEntityUsedInspection */
/** @noinspection PhpVoidFunctionResultUsedInspection */
declare(strict_types=1);

/**
 * Copyright (c) 2020-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-soar
 */

use Composer\Autoload\ClassLoader;
use Faker\Factory;
use Guanguans\LaravelSoarTests\TestCase;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Pest\Expectation;

uses(TestCase::class)
    ->beforeAll(function (): void {})
    ->beforeEach(function (): void {
        links([
            __DIR__.'/../'.basename($target = __DIR__.'/../vendor/orchestra/testbench-core/laravel') => $target,
        ]);

        /** @var TestCase $this */
        $this->defineEnvironment(app());
    })
    ->afterEach(function (): void {})
    ->afterAll(function (): void {})
    ->in(
        __DIR__,
        // __DIR__.'/Feature',
        // __DIR__.'/Unit'
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

expect()->extend('toBetween', fn (int $min, int $max): Expectation => expect($this->value)
    ->toBeGreaterThanOrEqual($min)
    ->toBeLessThanOrEqual($max));

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

function classes(): Collection
{
    return collect(spl_autoload_functions())
        ->pipe(static fn (Collection $splAutoloadFunctions): Collection => collect(
            $splAutoloadFunctions
                ->firstOrFail(
                    static fn (mixed $loader): bool => \is_array($loader) && $loader[0] instanceof ClassLoader
                )[0]
                ->getClassMap()
        ))
        ->keys();
}

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

function faker(string $locale = Factory::DEFAULT_LOCALE): Generator
{
    return fake($locale);
}

// function fake(string $locale = Factory::DEFAULT_LOCALE): Generator
// {
//     return Factory::create($locale);
// }

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

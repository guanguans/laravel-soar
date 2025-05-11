<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpPossiblePolymorphicInvocationInspection */
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpVoidFunctionResultUsedInspection */
/** @noinspection SqlResolve */
/** @noinspection StaticClosureCanBeUsedInspection */
/** @noinspection MethodVisibilityInspection */
/** @noinspection PhpMissingParentCallCommonInspection */
/** @noinspection PhpUnusedAliasInspection */
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

use Guanguans\LaravelSoar\Facades\Soar;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Orchestra\Testbench\Concerns\WithWorkbench;
use phpmock\phpunit\PHPMock;
use Symfony\Component\VarDumper\Test\VarDumperTestTrait;

class TestCase extends \Orchestra\Testbench\TestCase
{
    // use DatabaseTransactions;
    // use InteractsWithViews;
    // use LazilyRefreshDatabase;
    // use MockeryPHPUnitIntegration;
    // use PHPMock;
    // use VarDumperTestTrait;

    use RefreshDatabase;
    use WithWorkbench;

    protected function getApplicationTimezone(mixed $app): string
    {
        return 'Asia/Shanghai';
    }

    protected function getPackageAliases(mixed $app): array
    {
        return [
            'Soar' => Soar::class,
        ];
    }

    protected function defineEnvironment(mixed $app): void
    {
        tap($app->make(Repository::class), function (Repository $repository): void {
            $repository->set('app.key', 'base64:UZ5sDPZSB7DSLKY+DYlU8G/V1e/qW+Ag0WF03VNxiSg=');

            $repository->set('database.default', 'sqlite');
            $repository->set('database.connections.sqlite.database', ':memory:');

            $repository->set('soar.enabled', true);
            // $repository->set('soar.outputs', []);
            // $repository->set('soar.options.-test-dsn.disable', true);
            // $repository->set('soar.options.-online-dsn.disable', true);
        });
    }
}

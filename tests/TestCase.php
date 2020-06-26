<?php

/*
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Tests;

use Guanguans\LaravelSoar\SoarServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * Load package service provider.
     * @param  \Illuminate\Foundation\Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [SoarServiceProvider::class];
    }

    protected function setUp(): void
    {
        parent::setUp();
    }
}

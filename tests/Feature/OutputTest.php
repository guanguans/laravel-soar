<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Tests\Feature;

use Guanguans\LaravelSoar\OutputManager;
use Guanguans\LaravelSoar\Outputs\JsonOutput;
use Guanguans\LaravelSoar\Outputs\SoarBarOutput;
use Symfony\Component\Console\Command\Command;

beforeEach(function (): void {
    $this->see = [
        'Summary',
        'Basic',
        'HeuristicRules',
        'IndexRules',
        'Explain',
        'Backtraces',
    ];
});

it('can not output soar scores', function (): void {
    config()->set('soar.exclusions', ['outputs']);

    $this->artisan('outputs')
        ->assertExitCode(Command::SUCCESS)
        ->expectsOutput(OutputManager::class);

    // $this->get('outputs')
    //     ->assertOk()
    //     // ->assertSee($this->see)
    //     ->assertSee(OutputManager::class);
})->group(__DIR__, __FILE__);

it('can outputs console', function (): void {
    $this->artisan('outputs')
        ->assertExitCode(Command::SUCCESS)
        ->expectsOutput(OutputManager::class);
})->group(__DIR__, __FILE__);

it('can outputs http', function (): void {
    $this->get('outputs')
        ->assertOk()
        // ->assertSee($this->see)
        ->assertSee(OutputManager::class);
})->group(__DIR__, __FILE__);

it('can output to json', function (): void {
    $this->get('json')
        ->assertOk()
        // ->assertSee($this->see)
        ->assertSee(class_basename(JsonOutput::class));
})->group(__DIR__, __FILE__);

it('can output to SoarBar', function (): void {
    $this->get('soar-bar')
        ->assertOk()
        // ->assertSee($this->see)
        ->assertSee(SoarBarOutput::class);
})->group(__DIR__, __FILE__);

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

use Guanguans\LaravelSoar\Outputs\ClockworkOutput;
use Guanguans\LaravelSoar\Outputs\ConsoleOutput;
use Guanguans\LaravelSoar\Outputs\DebugBarOutput;
use Guanguans\LaravelSoar\Outputs\DumpOutput;
use Guanguans\LaravelSoar\Outputs\JsonOutput;
use Guanguans\LaravelSoar\Outputs\LogOutput;
use Guanguans\LaravelSoar\Outputs\NullOutput;
use Guanguans\LaravelSoar\Outputs\SoarBarOutput;

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

// it('can output to clockwork', function (): void {
//     $this->get('clockwork')
//         ->assertOk()
//         // ->assertSee($this->see)
//         ->assertSee(ClockworkOutput::class);
// })->group(__DIR__, __FILE__);

it('can output to console', function (): void {
    $this->get('console')
        ->assertOk()
        // ->dd()
        // ->assertSee($this->see)
        ->assertSee(ConsoleOutput::class);
})->group(__DIR__, __FILE__);
//
// it('can output to DebugBar', function (): void {
//     $this->get('debug-bar')
//         ->assertOk()
//         ->assertSee($this->see)
//         ->assertSee(DebugBarOutput::class);
// })->group(__DIR__, __FILE__);
//
// it('can output to dump', function (): void {
//     $this->get('dump')
//         ->assertOk()
//         ->assertSee($this->see)
//         ->assertSee(DumpOutput::class);
// })->group(__DIR__, __FILE__);
//
// it('can output to json', function (): void {
//     $this->get('json')
//         // ->dd()
//         ->assertOk()
//         // ->assertSee($this->see)
//         ->assertSee(JsonOutput::class);
// })->group(__DIR__, __FILE__);
//
// it('can output to log', function (): void {
//     $this->get('log')
//         ->assertOk()
//         ->assertSee($this->see)
//         ->assertSee(LogOutput::class);
// })->group(__DIR__, __FILE__);
//
// it('can output to null', function (): void {
//     $this->get('null')
//         ->assertOk()
//         ->assertSee($this->see)
//         ->assertSee(NullOutput::class);
// })->group(__DIR__, __FILE__);
//
// it('can output to SoarBar', function (): void {
//     $this->get('soar-bar')
//         ->assertOk()
//         ->assertSee($this->see)
//         ->assertSee(SoarBarOutput::class);
// })->group(__DIR__, __FILE__);

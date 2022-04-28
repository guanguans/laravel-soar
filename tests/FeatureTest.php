<?php

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Tests;

class FeatureTest extends TestCase
{
    public function testConsoleOutput()
    {
        $response = $this->get('/html');

        $response->assertSee('console.warn(');
        $response->assertSee('Summary');
        $response->assertSee('HeuristicRules');
        $response->assertSee('IndexRules');
        $response->assertSee('Explain');
        $response->assertSee('Backtraces');
    }

    public function testJsonOutput()
    {
        $response = $this->get('/json');

        $this->assertJson($json = $response->getContent());
        $response->assertSee('soar_scores');
        $response->assertSee('Summary');
        $response->assertSee('HeuristicRules');
        $response->assertSee('IndexRules');
        $response->assertSee('Explain');
        $response->assertSee('Backtraces');
    }

    public function testSoarBarOutput()
    {
        $response = $this->get('/html');

        $response->assertSee('background: #efefef url(data:image/svg+xml;base64,');
        $response->assertSee('Summary');
        $response->assertSee('HeuristicRules');
        $response->assertSee('IndexRules');
        $response->assertSee('Explain');
        $response->assertSee('Backtraces');
    }
}

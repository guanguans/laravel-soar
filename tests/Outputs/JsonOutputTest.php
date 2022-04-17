<?php

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Tests\Outputs;

use Tests\TestCase;

class JsonOutputTest extends TestCase
{
    public function testOutput()
    {
        // $this->markTestSkipped(__METHOD__.' is not implemented.');
        $response = $this->get('/json');
        $response->assertSee('soar');
        $response->assertSee('soar_scores');

        $response = $this->get('/html');
        $response->assertSee('soar');
        $response->assertDontSee('soar_scores');
    }
}

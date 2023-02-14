<?php

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Tests\Macros;

use Tests\Models\User;
use Tests\TestCase;

class QueryBuilderMacroTest extends TestCase
{
    public function testToRawSql()
    {
        $rawSql = User::query()->where('id', 1)->toRawSql();
        $this->assertEquals('select * from "users" where "id" = 1', $rawSql);
    }
}

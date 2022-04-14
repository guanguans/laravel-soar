<?php

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Tests\Seeder;

use Illuminate\Database\Seeder;
use Tests\Models\User;

class TestSeeder extends Seeder
{
    public function run()
    {
        factory(User::class, 5)->create();
    }
}

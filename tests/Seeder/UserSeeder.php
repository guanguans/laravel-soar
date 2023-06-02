<?php

declare(strict_types=1);

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

class UserSeeder extends Seeder
{
    public function run(): void
    {
        factory(User::class, 5)->create();
    }
}

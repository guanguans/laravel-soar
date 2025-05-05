<?php

declare(strict_types=1);

/**
 * Copyright (c) 2020-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-soar
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

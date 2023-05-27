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
use Illuminate\Support\Str;
use Tests\Models\User;

class TestSeeder extends Seeder
{
    public function run(): void
    {
        factory(User::class, 5)->create();

        User::query()->where('id', 1)->delete();

        User::query()->where('id', 2)->update([
            'email_verified_at' => now(),
            'password' => Str::random(32),
            'remember_token' => Str::random(10),
        ]);

        User::query()->where('name', 'soar')->groupBy('name')->orderBy('name')->first();
    }
}

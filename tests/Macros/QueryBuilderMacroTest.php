<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Tests\Macros;

use Tests\Models\User;

it('to raw sql', function (): void {
    $rawSql = User::query()->where('id', 1)->toRawSql();
    expect($rawSql)->toBe('select * from "users" where "id" = 1');
});

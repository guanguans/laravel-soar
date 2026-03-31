<?php

/** @noinspection PhpUnusedAliasInspection */
/** @noinspection UsingInclusionReturnValueInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2020-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-soar
 */

use Symplify\MonorepoBuilder\Config\MBConfig;

return static function (MBConfig $mbConfig): void {
    $callback = require __DIR__.'/vendor/guanguans/monorepo-builder-worker/monorepo-builder.php';
    $callback($mbConfig);
    $mbConfig->defaultBranch('master');
};

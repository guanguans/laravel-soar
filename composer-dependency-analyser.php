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

use ShipMonk\ComposerDependencyAnalyser\Config\Configuration;
use ShipMonk\ComposerDependencyAnalyser\Config\ErrorType;

return (new Configuration)
    ->addPathsToScan(
        [
            __DIR__.'/config',
            __DIR__.'/routes',
            __DIR__.'/src',
        ],
        false
    )
    ->addPathsToExclude([
        __DIR__.'/tests',
        // __DIR__.'/src/Support/Rectors',
    ])
    /** @see \ShipMonk\ComposerDependencyAnalyser\Analyser::CORE_EXTENSIONS */
    ->ignoreErrorsOnExtensions(
        [
            // 'ext-pdo',
        ],
        [ErrorType::SHADOW_DEPENDENCY]
    )
    ->ignoreErrorsOnPackages(
        [
            'nesbot/carbon',
            'symfony/console',
            'symfony/http-foundation',
            'symfony/var-dumper',
        ],
        [ErrorType::SHADOW_DEPENDENCY]
    )
    ->ignoreErrorsOnPackageAndPath(
        'barryvdh/laravel-debugbar',
        __DIR__.'/src/Outputs/DebugBarOutput.php',
        [ErrorType::DEV_DEPENDENCY_IN_PROD]
    )
    ->ignoreErrorsOnPackageAndPath(
        'spatie/ray',
        __DIR__.'/src/Outputs/RayOutput.php',
        [ErrorType::DEV_DEPENDENCY_IN_PROD]
    )
    ->ignoreErrorsOnPackages(
        [
            // 'guanguans/ai-commit',
        ],
        [ErrorType::DEV_DEPENDENCY_IN_PROD]
    );

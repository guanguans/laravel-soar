<?php

/** @noinspection MethodVisibilityInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2020-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-soar
 */

namespace Guanguans\LaravelSoar\Outputs\Concerns;

use Illuminate\Support\Collection;
use function Guanguans\LaravelSoar\Support\json_pretty_encode;

trait ScoresHydrator
{
    /**
     * @noinspection PhpStrictTypeCheckingInspection
     *
     * @throws \JsonException
     */
    protected function hydrateScores(Collection $scores): string
    {
        return $scores->reduce(
            fn (string $carry, array $score): string => $carry.\PHP_EOL.$this->hydrateScore($score),
            ''
        );
    }

    /**
     * @param array<string, mixed> $score
     *
     * @throws \JsonException
     */
    protected function hydrateScore(array $score): string
    {
        return ($score['Summary'] ?? '').\PHP_EOL.json_pretty_encode($score);
    }
}

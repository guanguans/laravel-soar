<?php

/** @noinspection DebugFunctionUsageInspection */
/** @noinspection ForgottenDebugOutputInspection */
/** @noinspection PhpMethodParametersCountMismatchInspection */
/** @noinspection PhpParamsInspection */
/** @noinspection PhpUnused */

declare(strict_types=1);

/**
 * Copyright (c) 2020-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-soar
 */

namespace Guanguans\LaravelSoar\Mixins;

use Guanguans\LaravelSoar\Facades\Soar;
use Guanguans\LaravelSoar\Support\Utils;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin \Illuminate\Database\Eloquent\Relations\Relation
 * @mixin \Illuminate\Database\Query\Builder
 */
class QueryBuilderMixin
{
    public function ddSoarScore(): \Closure
    {
        return fn (int $depth = 512, int $options = 0): mixed => dd($this->toSoarScore($depth, $options)); // @codeCoverageIgnore
    }

    public function dumpSoarScore(): \Closure
    {
        return function (int $depth = 512, int $options = 0): self {
            dump($this->toSoarScore($depth, $options));

            return $this;
        };
    }

    public function toSoarScore(): \Closure
    {
        return fn (int $depth = 512, int $options = 0): array => Soar::arrayScores(
            $this->toRawSql(),
            $depth,
            $options
        )[0];
    }

    public function ddRawSql(): \Closure
    {
        return fn (): mixed => dd($this->toRawSql()); // @codeCoverageIgnore
    }

    public function dumpRawSql(): \Closure
    {
        return function (): self {
            dump($this->toRawSql());

            return $this;
        };
    }

    public function toRawSql(): \Closure
    {
        return fn (): string => Utils::toRawSql($this);
    }
}

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

use Guanguans\LaravelSoar\Soar;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin \Illuminate\Database\Eloquent\Relations\Relation
 * @mixin \Illuminate\Database\Query\Builder
 */
class QueryBuilderMixin
{
    public function toRawSql(): \Closure
    {
        return fn (): string => vsprintf(
            str_replace(['%', '?', '%s%s'], ['%%', '%s', '?'], $this->toSql()),
            array_map(
                fn (mixed $binding): string => \is_string($binding)
                    ? $this->getConnection()->getPdo()->quote($binding)
                    : var_export($binding, true),
                $this->getConnection()->prepareBindings($this->getBindings())
            )
        );
    }

    public function dumpRawSql(): \Closure
    {
        return fn (): string => dump($this->toRawSql());
    }

    public function ddRawSql(): \Closure
    {
        return fn (): mixed => dd($this->toRawSql()); // @codeCoverageIgnore
    }

    public function toSoarArrayScores(): \Closure
    {
        return fn (int $depth = 512, int $options = 0): array => resolve(Soar::class)->arrayScores(
            $this->toRawSql(),
            $depth,
            $options
        );
    }

    public function dumpSoarArrayScores(): \Closure
    {
        return fn (int $depth = 512, int $options = 0): array => dump($this->toSoarArrayScores($depth, $options));
    }

    public function ddSoarArrayScores(): \Closure
    {
        return fn (int $depth = 512, int $options = 0): mixed => dd($this->toSoarArrayScores($depth, $options)); // @codeCoverageIgnore
    }

    public function toSoarJsonScores(): \Closure
    {
        return fn (): string => resolve(Soar::class)->jsonScores($this->toRawSql());
    }

    public function dumpSoarJsonScores(): \Closure
    {
        return fn (): string => dump($this->toSoarJsonScores());
    }

    public function ddSoarJsonScores(): \Closure
    {
        return fn (): mixed => dd($this->toSoarJsonScores()); // @codeCoverageIgnore
    }

    public function toSoarHtmlScores(): \Closure
    {
        return fn (): string => resolve(Soar::class)->htmlScores($this->toRawSql());
    }

    /**
     * @noinspection PhpToStringImplementationInspection
     * @noinspection ToStringCallInspection
     */
    public function echoSoarHtmlScores(): \Closure
    {
        return function (): void {
            echo $this->toSoarHtmlScores();
        };
    }

    public function exitSoarHtmlScores(): \Closure
    {
        return function (): void {
            exit($this->toSoarHtmlScores()); // @codeCoverageIgnore
        };
    }
}

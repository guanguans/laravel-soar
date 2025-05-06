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

namespace Guanguans\LaravelSoar\Mixins;

use Guanguans\LaravelSoar\Soar;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin \Illuminate\Database\Query\Builder
 */
class QueryBuilderMixin
{
    public function toRawSql(): \Closure
    {
        return fn (): string => array_reduce(
            $this->getBindings(),
            static fn (string $sql, mixed $binding): string => preg_replace('/\?/', is_numeric($binding) ? (string) $binding : "'".$binding."'", $sql, 1),
            $this->toSql()
        );
    }

    /**
     * @noinspection DebugFunctionUsageInspection
     * @noinspection ForgottenDebugOutputInspection
     */
    public function dumpRawSql(): \Closure
    {
        return fn (): string => dump($this->toRawSql());
    }

    /**
     * @noinspection DebugFunctionUsageInspection
     * @noinspection ForgottenDebugOutputInspection
     *
     * @codeCoverageIgnore
     */
    public function ddRawSql(): \Closure
    {
        return fn () => dd($this->toRawSql());
    }

    public function toSoarArrayScores(): \Closure
    {
        return fn (int $depth = 512, int $options = 0): array => resolve(Soar::class)->arrayScores(
            $this->toRawSql(),
            $depth,
            $options
        );
    }

    /**
     * @noinspection DebugFunctionUsageInspection
     * @noinspection ForgottenDebugOutputInspection
     */
    public function dumpSoarArrayScores(): \Closure
    {
        return fn (int $depth = 512, int $options = 0): array => dump($this->toSoarArrayScores($depth, $options));
    }

    /**
     * @noinspection DebugFunctionUsageInspection
     * @noinspection ForgottenDebugOutputInspection
     *
     * @codeCoverageIgnore
     */
    public function ddSoarArrayScores(): \Closure
    {
        return fn (int $depth = 512, int $options = 0) => dd($this->toSoarArrayScores($depth, $options));
    }

    public function toSoarJsonScores(): \Closure
    {
        return fn (): string => resolve(Soar::class)->jsonScores($this->toRawSql());
    }

    /**
     * @noinspection DebugFunctionUsageInspection
     * @noinspection ForgottenDebugOutputInspection
     */
    public function dumpSoarJsonScores(): \Closure
    {
        return fn (): string => dump($this->toSoarJsonScores());
    }

    /**
     * @noinspection DebugFunctionUsageInspection
     * @noinspection ForgottenDebugOutputInspection
     *
     * @codeCoverageIgnore
     */
    public function ddSoarJsonScores(): \Closure
    {
        return fn () => dd($this->toSoarJsonScores());
    }

    public function toSoarHtmlScores(): \Closure
    {
        return fn (): string => resolve(Soar::class)->htmlScores($this->toRawSql());
    }

    /**
     * @noinspection ToStringCallInspection
     */
    public function echoSoarHtmlScores(): \Closure
    {
        return function (): void {
            echo $this->toSoarHtmlScores();
        };
    }

    /**
     * @codeCoverageIgnore
     */
    public function exitSoarHtmlScores(): \Closure
    {
        return function (): void {
            exit($this->toSoarHtmlScores());
        };
    }
}

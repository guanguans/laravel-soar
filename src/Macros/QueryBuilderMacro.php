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

namespace Guanguans\LaravelSoar\Macros;

use Guanguans\LaravelSoar\Soar;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin \Illuminate\Database\Query\Builder
 */
class QueryBuilderMacro
{
    /**
     * @psalm-suppress InvalidReturnType
     * @psalm-suppress InvalidReturnStatement
     */
    public function toRawSql(): callable
    {
        return fn (): string => array_reduce(
            $this->getBindings(),
            static fn ($sql, $binding) => preg_replace('/\?/', is_numeric($binding) ? (string) $binding : "'".$binding."'", $sql, 1),
            $this->toSql()
        );
    }

    /**
     * @noinspection DebugFunctionUsageInspection
     * @noinspection ForgottenDebugOutputInspection
     */
    public function dumpRawSql(): callable
    {
        return fn (): string => dump($this->toRawSql());
    }

    /**
     * @noinspection DebugFunctionUsageInspection
     * @noinspection ForgottenDebugOutputInspection
     *
     * @codeCoverageIgnore
     */
    public function ddRawSql(): callable
    {
        return fn () => dd($this->toRawSql());
    }

    public function toSoarArrayScores(): callable
    {
        return fn (int $depth = 512, int $options = 0): array => app(Soar::class)->arrayScores(
            $this->toRawSql(),
            $depth,
            $options
        );
    }

    /**
     * @noinspection DebugFunctionUsageInspection
     * @noinspection ForgottenDebugOutputInspection
     */
    public function dumpSoarArrayScores(): callable
    {
        return fn (int $depth = 512, int $options = 0): array => dump($this->toSoarArrayScores($depth, $options));
    }

    /**
     * @noinspection DebugFunctionUsageInspection
     * @noinspection ForgottenDebugOutputInspection
     *
     * @codeCoverageIgnore
     */
    public function ddSoarArrayScores(): callable
    {
        return fn (int $depth = 512, int $options = 0) => dd($this->toSoarArrayScores($depth, $options));
    }

    public function toSoarJsonScores(): callable
    {
        return fn (): string => app(Soar::class)->jsonScores($this->toRawSql());
    }

    /**
     * @noinspection DebugFunctionUsageInspection
     * @noinspection ForgottenDebugOutputInspection
     */
    public function dumpSoarJsonScores(): callable
    {
        return fn (): string => dump($this->toSoarJsonScores());
    }

    /**
     * @noinspection DebugFunctionUsageInspection
     * @noinspection ForgottenDebugOutputInspection
     *
     * @codeCoverageIgnore
     */
    public function ddSoarJsonScores(): callable
    {
        return fn () => dd($this->toSoarJsonScores());
    }

    public function toSoarHtmlScores(): callable
    {
        return fn (): string => app(Soar::class)->htmlScores($this->toRawSql());
    }

    /**
     * @noinspection ToStringCallInspection
     */
    public function echoSoarHtmlScores(): callable
    {
        return function (): void {
            echo $this->toSoarHtmlScores();
        };
    }

    /**
     * @codeCoverageIgnore
     */
    public function exitSoarHtmlScores(): callable
    {
        return function (): void {
            exit($this->toSoarHtmlScores());
        };
    }
}

<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelSoar\Macros;

use Guanguans\LaravelSoar\Soar;

/**
 * @mixin \Illuminate\Database\Query\Builder
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin \Illuminate\Database\Query\Builder
 */
class QueryBuilderMacro
{
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
        return function (): void {
            dump($this->toRawSql());
        };
    }

    /**
     * @noinspection DebugFunctionUsageInspection
     * @noinspection ForgottenDebugOutputInspection
     */
    public function ddRawSql(): callable
    {
        return function (): void {
            dd($this->toRawSql());
        };
    }

    public function toSoarArrayScores(): callable
    {
        return fn (): array => app(Soar::class)->arrayScores($this->toRawSql());
    }

    /**
     * @noinspection DebugFunctionUsageInspection
     * @noinspection ForgottenDebugOutputInspection
     */
    public function dumpSoarArrayScores(): callable
    {
        return function (): void {
            dump($this->toSoarArrayScores());
        };
    }

    /**
     * @noinspection DebugFunctionUsageInspection
     * @noinspection ForgottenDebugOutputInspection
     */
    public function ddSoarArrayScores(): callable
    {
        return function (): void {
            dd($this->toSoarArrayScores());
        };
    }

    public function toSoarJsonScores(): callable
    {
        return fn (int $options = 0, int $depth = 128): string => json_encode(
            $this->toSoarArrayScores(),
            $options | JSON_THROW_ON_ERROR,
            $depth
        );
    }

    /**
     * @noinspection DebugFunctionUsageInspection
     * @noinspection ForgottenDebugOutputInspection
     */
    public function dumpSoarJsonScores(): callable
    {
        return function (int $options = JSON_PRETTY_PRINT, int $depth = 128): void {
            dump($this->toSoarJsonScores($options, $depth));
        };
    }

    /**
     * @noinspection DebugFunctionUsageInspection
     * @noinspection ForgottenDebugOutputInspection
     */
    public function ddSoarJsonScores(): callable
    {
        return function (int $options = JSON_PRETTY_PRINT, int $depth = 128): void {
            dd($this->toSoarJsonScores($options, $depth));
        };
    }

    public function toSoarHtmlScores(): callable
    {
        return fn (): string => app(Soar::class)->htmlScores($this->toRawSql());
    }

    public function echoSoarHtmlScores(): callable
    {
        return function (): void {
            echo $this->toSoarHtmlScores();
        };
    }

    public function exitSoarHtmlScores(): callable
    {
        return function (): void {
            exit($this->toSoarHtmlScores());
        };
    }
}

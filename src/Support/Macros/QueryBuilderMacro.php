<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelSoar\Support\Macros;

/**
 * @mixin \Illuminate\Database\Query\Builder
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin \Illuminate\Database\Query\Builder
 */
class QueryBuilderMacro
{
    public function toRawSql()
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
    public function dumpRawSql()
    {
        return function (): void {
            dump($this->toRawSql());
        };
    }

    /**
     * @noinspection DebugFunctionUsageInspection
     * @noinspection ForgottenDebugOutputInspection
     */
    public function ddRawSql()
    {
        return function (): void {
            dd($this->toRawSql());
        };
    }

    public function toSoarArrayScores()
    {
        return fn (): array => app('soar')->arrayScores($this->toRawSql());
    }

    /**
     * @noinspection DebugFunctionUsageInspection
     * @noinspection ForgottenDebugOutputInspection
     */
    public function dumpSoarArrayScores()
    {
        return function (): void {
            dump($this->toSoarArrayScores($this->toRawSql()));
        };
    }

    /**
     * @noinspection DebugFunctionUsageInspection
     * @noinspection ForgottenDebugOutputInspection
     */
    public function ddSoarArrayScores()
    {
        return function (): void {
            dd($this->toSoarArrayScores($this->toRawSql()));
        };
    }

    public function toSoarJsonScores()
    {
        return fn ($options = 0, $depth = 128): string => json_encode($this->toSoarArrayScores($this->toRawSql()), $options | JSON_THROW_ON_ERROR, $depth);
    }

    /**
     * @noinspection DebugFunctionUsageInspection
     * @noinspection ForgottenDebugOutputInspection
     */
    public function dumpSoarJsonScores()
    {
        return function ($options = JSON_PRETTY_PRINT, $depth = 128): void {
            dump($this->toSoarJsonScores($options, $depth));
        };
    }

    /**
     * @noinspection DebugFunctionUsageInspection
     * @noinspection ForgottenDebugOutputInspection
     */
    public function ddSoarJsonScores()
    {
        return function ($options = JSON_PRETTY_PRINT, $depth = 128): void {
            dd($this->toSoarJsonScores($options, $depth));
        };
    }

    public function toSoarHtmlScores()
    {
        return fn (): string => app('soar')->htmlScores($this->toRawSql());
    }

    /**
     * @noinspection PhpToStringImplementationInspection
     */
    public function echoSoarHtmlScores()
    {
        return function (): void {
            echo $this->toSoarHtmlScores($this->toRawSql());
        };
    }

    public function exitSoarHtmlScores()
    {
        return function (): void {
            exit($this->toSoarHtmlScores($this->toRawSql()));
        };
    }
}

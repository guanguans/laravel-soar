<?php

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelSoar\Support\Macros;

class QueryBuilderMacro
{
    public function toRawSql()
    {
        return function (): string {
            /* @var \Illuminate\Database\Query\Builder $this */
            return array_reduce($this->getBindings(), function ($sql, $binding) {
                return preg_replace('/\?/', is_numeric($binding) ? (string) $binding : "'".$binding."'", $sql, 1);
            }, $this->toSql());
        };
    }

    public function dumpRawSql()
    {
        return function (): string {
            /* @var \Illuminate\Database\Query\Builder $this */
            return dump($this->toRawSql());
        };
    }

    public function ddRawSql()
    {
        return function (): string {
            /* @var \Illuminate\Database\Query\Builder $this */
            return dd($this->toRawSql());
        };
    }

    public function toSoarArrayScore()
    {
        return function (): array {
            /* @var \Illuminate\Database\Query\Builder $this */
            $arrayScore = app('soar')->arrayScore($this->toRawSql());

            return $arrayScore[0] ?? $arrayScore;
        };
    }

    public function dumpSoarArrayScore()
    {
        return function (): void {
            /* @var \Illuminate\Database\Query\Builder $this */
            dump($this->toSoarArrayScore($this->toRawSql()));
        };
    }

    public function ddSoarArrayScore()
    {
        return function (): void {
            /* @var \Illuminate\Database\Query\Builder $this */
            dd($this->toSoarArrayScore($this->toRawSql()));
        };
    }

    public function toSoarJsonScore()
    {
        return function ($options = 0, $depth = 128): string {
            /* @var \Illuminate\Database\Query\Builder $this */
            return json_encode($this->toSoarArrayScore($this->toRawSql()), $options, $depth);
        };
    }

    public function dumpSoarJsonScore()
    {
        return function ($options = JSON_PRETTY_PRINT, $depth = 128): void {
            /* @var \Illuminate\Database\Query\Builder $this */
            dump($this->toSoarJsonScore($options, $depth));
        };
    }

    public function ddSoarJsonScore()
    {
        return function ($options = JSON_PRETTY_PRINT, $depth = 128): void {
            /* @var \Illuminate\Database\Query\Builder $this */
            dd($this->toSoarJsonScore($options, $depth));
        };
    }

    public function toSoarHtmlScore()
    {
        return function (): string {
            /* @var \Illuminate\Database\Query\Builder $this */
            return app('soar')->htmlScore($this->toRawSql());
        };
    }

    public function echoSoarHtmlScore()
    {
        return function (): void {
            /* @var \Illuminate\Database\Query\Builder $this */
            echo $this->toSoarHtmlScore($this->toRawSql());
        };
    }

    public function exitSoarHtmlScore()
    {
        return function (): void {
            /* @var \Illuminate\Database\Query\Builder $this */
            exit($this->toSoarHtmlScore($this->toRawSql()));
        };
    }

    public function toSoarHtmlExplain()
    {
        return function (): string {
            /* @var \Illuminate\Database\Query\Builder $this */
            return app('soar')->htmlExplain($this->toRawSql());
        };
    }

    public function echoSoarHtmlExplain()
    {
        return function (): void {
            /* @var \Illuminate\Database\Query\Builder $this */
            echo $this->toSoarHtmlExplain($this->toRawSql());
        };
    }

    public function exitSoarHtmlExplain()
    {
        return function (): void {
            /* @var \Illuminate\Database\Query\Builder $this */
            exit($this->toSoarHtmlExplain($this->toRawSql()));
        };
    }
}

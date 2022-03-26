<?php

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelSoar\Macros;

use Guanguans\LaravelSoar\Facades\Soar;

class QueryBuilderMacro
{
    public function toSoarScore()
    {
        return function (): string {
            /* @var \Illuminate\Database\Query\Builder $this */
            $sql = $this->{config('dumpsql.to_raw_sql', 'toRawSql')}();

            return Soar::score($sql);
        };
    }

    public function dumpSoarScore()
    {
        return function () {
            /* @var \Illuminate\Database\Query\Builder $this */
            $sql = $this->{config('dumpsql.to_raw_sql', 'toRawSql')}();

            echo Soar::score($sql);
        };
    }

    public function ddSoarScore()
    {
        return function () {
            /* @var \Illuminate\Database\Query\Builder $this */
            $sql = $this->{config('dumpsql.to_raw_sql', 'toRawSql')}();

            exit(Soar::score($sql));
        };
    }

    public function toSoarMdExplain()
    {
        return function () {
            /* @var \Illuminate\Database\Query\Builder $this */
            $sql = $this->{config('dumpsql.to_raw_sql', 'toRawSql')}();

            return Soar::mdExplain($sql);
        };
    }

    public function dumpSoarMdExplain()
    {
        return function () {
            /* @var \Illuminate\Database\Query\Builder $this */
            $sql = $this->{config('dumpsql.to_raw_sql', 'toRawSql')}();

            echo Soar::mdExplain($sql);
        };
    }

    public function ddSoarMdExplain()
    {
        return function () {
            /* @var \Illuminate\Database\Query\Builder $this */
            $sql = $this->{config('dumpsql.to_raw_sql', 'toRawSql')}();

            exit(Soar::mdExplain($sql));
        };
    }

    public function toSoarHtmlExplain()
    {
        return function () {
            /* @var \Illuminate\Database\Query\Builder $this */
            $sql = $this->{config('dumpsql.to_raw_sql', 'toRawSql')}();

            return Soar::htmlExplain($sql);
        };
    }

    public function dumpSoarHtmlExplain()
    {
        return function () {
            /* @var \Illuminate\Database\Query\Builder $this */
            $sql = $this->{config('dumpsql.to_raw_sql', 'toRawSql')}();

            echo Soar::htmlExplain($sql);
        };
    }

    public function ddSoarHtmlExplain()
    {
        return function () {
            /* @var \Illuminate\Database\Query\Builder $this */
            $sql = $this->{config('dumpsql.to_raw_sql', 'toRawSql')}();

            exit(Soar::htmlExplain($sql));
        };
    }

    public function toSoarPretty()
    {
        return function () {
            /* @var \Illuminate\Database\Query\Builder $this */
            $sql = $this->{config('dumpsql.to_raw_sql', 'toRawSql')}();

            return Soar::pretty($sql);
        };
    }

    public function dumpSoarPretty()
    {
        return function () {
            /* @var \Illuminate\Database\Query\Builder $this */
            $sql = $this->{config('dumpsql.to_raw_sql', 'toRawSql')}();
            echo '<pre>';
            echo Soar::pretty($sql);
        };
    }

    public function ddSoarPretty()
    {
        return function () {
            /* @var \Illuminate\Database\Query\Builder $this */
            $sql = $this->{config('dumpsql.to_raw_sql', 'toRawSql')}();
            echo '<pre>';
            exit(Soar::pretty($sql));
        };
    }

    public function toSoarHelp()
    {
        return function () {
            return Soar::help();
        };
    }

    public function dumpSoarHelp()
    {
        return function () {
            echo '<pre>';
            echo Soar::help();
        };
    }

    public function ddSoarHelp()
    {
        return function () {
            echo '<pre>';
            exit(Soar::help());
        };
    }
}

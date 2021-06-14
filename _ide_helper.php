<?php

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace {
    class DB extends \Illuminate\Support\Facades\DB
    {
    }

    class Eloquent extends \Illuminate\Database\Eloquent\Model
    {
        /**
         * @see \Guanguans\LaravelDumpSql\ServiceProvider::registerEloquentBuilderMethod()
         */
        public function toSoarScore()
        {
            return \Illuminate\Database\Eloquent\Builder::toSoarScore();
        }

        /**
         * @see \Guanguans\LaravelDumpSql\ServiceProvider::registerEloquentBuilderMethod()
         */
        public function dumpSoarScore()
        {
            return \Illuminate\Database\Eloquent\Builder::dumpSoarScore();
        }

        /**
         * @see \Guanguans\LaravelDumpSql\ServiceProvider::registerEloquentBuilderMethod()
         */
        public function ddSoarScore()
        {
            return \Illuminate\Database\Eloquent\Builder::ddSoarScore();
        }

        /**
         * @see \Guanguans\LaravelDumpSql\ServiceProvider::registerEloquentBuilderMethod()
         */
        public function toSoarMdExplain()
        {
            return \Illuminate\Database\Eloquent\Builder::toSoarMdExplain();
        }

        /**
         * @see \Guanguans\LaravelDumpSql\ServiceProvider::registerEloquentBuilderMethod()
         */
        public function dumpSoarMdExplain()
        {
            return \Illuminate\Database\Eloquent\Builder::dumpSoarMdExplain();
        }

        /**
         * @see \Guanguans\LaravelDumpSql\ServiceProvider::registerEloquentBuilderMethod()
         */
        public function ddSoarMdExplain()
        {
            return \Illuminate\Database\Eloquent\Builder::ddSoarMdExplain();
        }

        /**
         * @see \Guanguans\LaravelDumpSql\ServiceProvider::registerEloquentBuilderMethod()
         */
        public function toSoarHtmlExplain()
        {
            return \Illuminate\Database\Eloquent\Builder::toSoarHtmlExplain();
        }

        /**
         * @see \Guanguans\LaravelDumpSql\ServiceProvider::registerEloquentBuilderMethod()
         */
        public function dumpSoarHtmlExplain()
        {
            return \Illuminate\Database\Eloquent\Builder::dumpSoarHtmlExplain();
        }

        /**
         * @see \Guanguans\LaravelDumpSql\ServiceProvider::registerEloquentBuilderMethod()
         */
        public function ddSoarHtmlExplain()
        {
            return \Illuminate\Database\Eloquent\Builder::ddSoarHtmlExplain();
        }

        /**
         * @see \Guanguans\LaravelDumpSql\ServiceProvider::registerEloquentBuilderMethod()
         */
        public function toSoarPretty()
        {
            return \Illuminate\Database\Eloquent\Builder::toSoarPretty();
        }

        /**
         * @see \Guanguans\LaravelDumpSql\ServiceProvider::registerEloquentBuilderMethod()
         */
        public function dumpSoarPretty()
        {
            return \Illuminate\Database\Eloquent\Builder::toSoarPretty();
        }

        /**
         * @see \Guanguans\LaravelDumpSql\ServiceProvider::registerEloquentBuilderMethod()
         */
        public function ddSoarPretty()
        {
            return \Illuminate\Database\Eloquent\Builder::ddSoarPretty();
        }

        /**
         * @see \Guanguans\LaravelDumpSql\ServiceProvider::registerEloquentBuilderMethod()
         */
        public function toSoarHelp()
        {
            return \Illuminate\Database\Eloquent\Builder::toSoarHelp();
        }

        /**
         * @see \Guanguans\LaravelDumpSql\ServiceProvider::registerEloquentBuilderMethod()
         */
        public function dumpSoarHelp()
        {
            return \Illuminate\Database\Eloquent\Builder::dumpSoarHelp();
        }

        /**
         * @see \Guanguans\LaravelDumpSql\ServiceProvider::registerEloquentBuilderMethod()
         */
        public function ddSoarHelp()
        {
            return \Illuminate\Database\Eloquent\Builder::ddSoarHelp();
        }
    }
}

namespace Illuminate\Database\Query {
    class Builder
    {
        /**
         * @see \Guanguans\LaravelSoar\SoarServiceProvider::boot()
         */
        public function toSoarScore()
        {
            return \Illuminate\Database\Query\Builder::toSoarScore();
        }

        /**
         * @see \Guanguans\LaravelSoar\SoarServiceProvider::boot()
         */
        public function dumpSoarScore()
        {
            return \Illuminate\Database\Query\Builder::ddSoarScore();
        }

        /**
         * @see \Guanguans\LaravelSoar\SoarServiceProvider::boot()
         */
        public function ddSoarScore()
        {
            return \Illuminate\Database\Query\Builder::ddSoarScore();
        }

        /**
         * @see \Guanguans\LaravelDumpSql\ServiceProvider::registerEloquentBuilderMethod()
         */
        public function toSoarMdExplain()
        {
            return \Illuminate\Database\Eloquent\Builder::toSoarMdExplain();
        }

        /**
         * @see \Guanguans\LaravelDumpSql\ServiceProvider::registerEloquentBuilderMethod()
         */
        public function dumpSoarMdExplain()
        {
            return \Illuminate\Database\Eloquent\Builder::dumpSoarMdExplain();
        }

        /**
         * @see \Guanguans\LaravelDumpSql\ServiceProvider::registerEloquentBuilderMethod()
         */
        public function ddSoarMdExplain()
        {
            return \Illuminate\Database\Eloquent\Builder::ddSoarMdExplain();
        }

        /**
         * @see \Guanguans\LaravelDumpSql\ServiceProvider::registerEloquentBuilderMethod()
         */
        public function toSoarHtmlExplain()
        {
            return \Illuminate\Database\Eloquent\Builder::toSoarHtmlExplain();
        }

        /**
         * @see \Guanguans\LaravelDumpSql\ServiceProvider::registerEloquentBuilderMethod()
         */
        public function dumpSoarHtmlExplain()
        {
            return \Illuminate\Database\Eloquent\Builder::dumpSoarHtmlExplain();
        }

        /**
         * @see \Guanguans\LaravelDumpSql\ServiceProvider::registerEloquentBuilderMethod()
         */
        public function ddSoarHtmlExplain()
        {
            return \Illuminate\Database\Eloquent\Builder::ddSoarHtmlExplain();
        }

        /**
         * @see \Guanguans\LaravelDumpSql\ServiceProvider::registerEloquentBuilderMethod()
         */
        public function toSoarPretty()
        {
            return \Illuminate\Database\Eloquent\Builder::toSoarPretty();
        }

        /**
         * @see \Guanguans\LaravelDumpSql\ServiceProvider::registerEloquentBuilderMethod()
         */
        public function dumpSoarPretty()
        {
            return \Illuminate\Database\Eloquent\Builder::dumpSoarPretty();
        }

        /**
         * @see \Guanguans\LaravelDumpSql\ServiceProvider::registerEloquentBuilderMethod()
         */
        public function ddSoarPretty()
        {
            return \Illuminate\Database\Eloquent\Builder::ddSoarPretty();
        }

        /**
         * @see \Guanguans\LaravelDumpSql\ServiceProvider::registerEloquentBuilderMethod()
         */
        public function toSoarHelp()
        {
            return \Illuminate\Database\Eloquent\Builder::toSoarHelp();
        }

        /**
         * @see \Guanguans\LaravelDumpSql\ServiceProvider::registerEloquentBuilderMethod()
         */
        public function dumpSoarHelp()
        {
            return \Illuminate\Database\Eloquent\Builder::dumpSoarHelp();
        }

        /**
         * @see \Guanguans\LaravelDumpSql\ServiceProvider::registerEloquentBuilderMethod()
         */
        public function ddSoarHelp()
        {
            return \Illuminate\Database\Eloquent\Builder::ddSoarHelp();
        }
    }
}

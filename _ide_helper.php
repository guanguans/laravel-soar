<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace {
    class Soar extends Guanguans\LaravelSoar\Facades\Soar {}
}

namespace Illuminate\Database\Query {
    /**
     * @method string toRawSql()
     * @method void dumpRawSql()
     * @method void ddRawSql()
     * @method array toSoarArrayScores(int $depth = 512, int $options = 0)
     * @method void dumpSoarArrayScores(int $depth = 512, int $options = 0)
     * @method void ddSoarArrayScores(int $depth = 512, int $options = 0)
     * @method string toSoarJsonScores()
     * @method void dumpSoarJsonScores()
     * @method void ddSoarJsonScores()
     * @method string toSoarHtmlScores()
     * @method void echoSoarHtmlScores()
     * @method void exitSoarHtmlScores()
     *
     * @see \Guanguans\LaravelSoar\Macros\QueryBuilderMacro
     * @see \Illuminate\Database\Query\Builder
     */
    class Builder {}
}

namespace Illuminate\Database\Eloquent {
    /**
     * @method string toRawSql()
     * @method void dumpRawSql()
     * @method void ddRawSql()
     * @method array toSoarArrayScores(int $depth = 512, int $options = 0)
     * @method void dumpSoarArrayScores(int $depth = 512, int $options = 0)
     * @method void ddSoarArrayScores(int $depth = 512, int $options = 0)
     * @method string toSoarJsonScores()
     * @method void dumpSoarJsonScores()
     * @method void ddSoarJsonScores()
     * @method string toSoarHtmlScores()
     * @method void echoSoarHtmlScores()
     * @method void exitSoarHtmlScores()
     *
     * @mixin \Illuminate\Database\Query\Builder
     *
     * @see \Guanguans\LaravelSoar\Macros\QueryBuilderMacro
     * @see \Illuminate\Database\Eloquent\Builder
     */
    class Builder {}
}

namespace Illuminate\Database\Eloquent\Relations {
    /**
     * @method string toRawSql()
     * @method void dumpRawSql()
     * @method void ddRawSql()
     * @method array toSoarArrayScores(int $depth = 512, int $options = 0)
     * @method void dumpSoarArrayScores(int $depth = 512, int $options = 0)
     * @method void ddSoarArrayScores(int $depth = 512, int $options = 0)
     * @method string toSoarJsonScores()
     * @method void dumpSoarJsonScores()
     * @method void ddSoarJsonScores()
     * @method string toSoarHtmlScores()
     * @method void echoSoarHtmlScores()
     * @method void exitSoarHtmlScores()
     *
     * @mixin \Illuminate\Database\Eloquent\Builder
     *
     * @see \Guanguans\LaravelSoar\Macros\QueryBuilderMacro
     * @see \Illuminate\Database\Eloquent\Relations\Relation
     */
    class Relation {}
}

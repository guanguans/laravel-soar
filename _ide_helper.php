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

namespace {
    class Soar extends Guanguans\LaravelSoar\Facades\Soar {}
}

namespace Illuminate\Database\Query {
    /**
     * @method void ddRawSql()
     * @method void ddSoarArrayScores(int $depth = 512, int $options = 0)
     * @method void ddSoarJsonScores()
     * @method void dumpRawSql()
     * @method void dumpSoarArrayScores(int $depth = 512, int $options = 0)
     * @method void dumpSoarJsonScores()
     * @method void echoSoarHtmlScores()
     * @method void exitSoarHtmlScores()
     * @method string toRawSql()
     * @method array toSoarArrayScores(int $depth = 512, int $options = 0)
     * @method string toSoarHtmlScores()
     * @method string toSoarJsonScores()
     *
     * @see \Guanguans\LaravelSoar\Macros\QueryBuilderMacro
     * @see \Illuminate\Database\Query\Builder
     */
    class Builder {}
}

namespace Illuminate\Database\Eloquent {
    /**
     * @method void ddRawSql()
     * @method void ddSoarArrayScores(int $depth = 512, int $options = 0)
     * @method void ddSoarJsonScores()
     * @method void dumpRawSql()
     * @method void dumpSoarArrayScores(int $depth = 512, int $options = 0)
     * @method void dumpSoarJsonScores()
     * @method void echoSoarHtmlScores()
     * @method void exitSoarHtmlScores()
     * @method string toRawSql()
     * @method array toSoarArrayScores(int $depth = 512, int $options = 0)
     * @method string toSoarHtmlScores()
     * @method string toSoarJsonScores()
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
     * @method void ddRawSql()
     * @method void ddSoarArrayScores(int $depth = 512, int $options = 0)
     * @method void ddSoarJsonScores()
     * @method void dumpRawSql()
     * @method void dumpSoarArrayScores(int $depth = 512, int $options = 0)
     * @method void dumpSoarJsonScores()
     * @method void echoSoarHtmlScores()
     * @method void exitSoarHtmlScores()
     * @method string toRawSql()
     * @method array toSoarArrayScores(int $depth = 512, int $options = 0)
     * @method string toSoarHtmlScores()
     * @method string toSoarJsonScores()
     *
     * @mixin \Illuminate\Database\Eloquent\Builder
     *
     * @see \Guanguans\LaravelSoar\Macros\QueryBuilderMacro
     * @see \Illuminate\Database\Eloquent\Relations\Relation
     */
    class Relation {}
}

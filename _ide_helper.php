<?php

/** @noinspection PhpMultipleClassDeclarationsInspection */

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
     * @method never ddRawSql()
     * @method never ddSoarArrayScores(int $depth = 512, int $options = 0)
     * @method self dumpRawSql()
     * @method self dumpSoarArrayScores(int $depth = 512, int $options = 0)
     * @method string toRawSql()
     * @method array toSoarArrayScores(int $depth = 512, int $options = 0)
     *
     * @mixin \Illuminate\Database\Eloquent\Builder
     *
     * @see \Guanguans\LaravelSoar\Mixins\QueryBuilderMixin
     * @see \Illuminate\Database\Query\Builder
     */
    class Builder {}
}

namespace Illuminate\Database\Eloquent {
    /**
     * @method never ddRawSql()
     * @method never ddSoarArrayScores(int $depth = 512, int $options = 0)
     * @method self dumpRawSql()
     * @method self dumpSoarArrayScores(int $depth = 512, int $options = 0)
     * @method string toRawSql()
     * @method array toSoarArrayScores(int $depth = 512, int $options = 0)
     *
     * @mixin \Illuminate\Database\Query\Builder
     *
     * @see \Guanguans\LaravelSoar\Mixins\QueryBuilderMixin
     * @see \Illuminate\Database\Eloquent\Builder
     */
    class Builder {}
}

namespace Illuminate\Database\Eloquent\Relations {
    /**
     * @method never ddRawSql()
     * @method never ddSoarArrayScores(int $depth = 512, int $options = 0)
     * @method self dumpRawSql()
     * @method self dumpSoarArrayScores(int $depth = 512, int $options = 0)
     * @method string toRawSql()
     * @method array toSoarArrayScores(int $depth = 512, int $options = 0)
     *
     * @mixin \Illuminate\Database\Eloquent\Builder
     *
     * @see \Guanguans\LaravelSoar\Mixins\QueryBuilderMixin
     * @see \Illuminate\Database\Eloquent\Relations\Relation
     */
    class Relation {}
}

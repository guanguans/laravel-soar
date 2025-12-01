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
     * @method never ddSoarScore(int $depth = 512, int $options = 0)
     * @method self dumpSoarScore(int $depth = 512, int $options = 0)
     * @method array toSoarScore(int $depth = 512, int $options = 0)
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
     * @method never ddSoarScore(int $depth = 512, int $options = 0)
     * @method self dumpSoarScore(int $depth = 512, int $options = 0)
     * @method array toSoarScore(int $depth = 512, int $options = 0)
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
     * @method never ddSoarScore(int $depth = 512, int $options = 0)
     * @method self dumpSoarScore(int $depth = 512, int $options = 0)
     * @method array toSoarScore(int $depth = 512, int $options = 0)
     *
     * @mixin \Illuminate\Database\Eloquent\Builder
     *
     * @see \Guanguans\LaravelSoar\Mixins\QueryBuilderMixin
     * @see \Illuminate\Database\Eloquent\Relations\Relation
     */
    class Relation {}
}

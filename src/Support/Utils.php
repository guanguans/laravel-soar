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

namespace Guanguans\LaravelSoar\Support;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Str;

class Utils
{
    public static function star(int $score): string
    {
        return str_repeat('★', $good = (int) round($score / 100 * 5)).str_repeat('☆', 5 - $good);
    }

    public static function sanitizeExplain(?array $explain): array
    {
        return collect($explain)
            ->map(static function (array $explain): array {
                $explain['Content'] = str($explain['Content'])->explode(\PHP_EOL)->filter()->values()->all();
                $explain['Case'] = str($explain['Case'])->explode(\PHP_EOL)->filter()->values()->all();

                return $explain;
            })
            ->all();
    }

    public static function isExceptQuery(string $query): bool
    {
        return Str::is(config('soar.except_queries', []), $query);
    }

    /**
     * @noinspection DebugFunctionUsageInspection
     */
    public static function toRawSql(QueryExecuted $queryExecuted): string
    {
        if (method_exists($queryExecuted, 'toRawSql')) {
            return $queryExecuted->toRawSql(); // @codeCoverageIgnore
        }

        if ([] === $queryExecuted->bindings) {
            return $queryExecuted->sql;
        }

        return vsprintf(
            str_replace(['%', '?', '%s%s'], ['%%', '%s', '?'], $queryExecuted->sql),
            array_map(
                static fn (mixed $binding): string => \is_string($binding)
                    ? $queryExecuted->connection->getPdo()->quote($binding)
                    : var_export($binding, true),
                $queryExecuted->connection->prepareBindings($queryExecuted->bindings)
            )
        );
    }

    /**
     * @noinspection DebugFunctionUsageInspection
     *
     * @param int|list<int> $forgetLines
     */
    public static function backtraces(int $limit = 0, array|int $forgetLines = 0): array
    {
        return collect(debug_backtrace(\DEBUG_BACKTRACE_IGNORE_ARGS, $limit))
            ->forget($forgetLines)
            ->filter(
                static fn (array $trace): bool => isset($trace['file'], $trace['line'])
                    && !Str::contains($trace['file'], 'vendor')
            )
            ->map(static fn (array $trace, int $index): string => \sprintf(
                '#%s %s:%s',
                $index,
                str_replace(base_path(), '', $trace['file']),
                $trace['line']
            ))
            ->values()
            ->all();
    }
}

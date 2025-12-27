<?php

declare(strict_types=1);

/**
 * Copyright (c) 2020-2026 guanguans<ityaozm@gmail.com>
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
                str_replace(Str::finish(base_path(), \DIRECTORY_SEPARATOR), '', $trace['file']),
                $trace['line']
            ))
            ->all();
    }

    public static function isExceptQuery(string $query): bool
    {
        return Str::is(config('soar.except_queries', []), $query);
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

    public static function star(int $score): string
    {
        return str_repeat('★', $good = (int) round($score / 100 * 5)).str_repeat('☆', 5 - $good);
    }

    /**
     * @see \Illuminate\Database\Query\Builder::toRawSql()
     * @see https://github.com/laravel/framework/blob/12.x/src/Illuminate/Database/Events/QueryExecuted.php
     * @see \Laravel\Telescope\Watchers\QueryWatcher::replaceBindings()
     * @see addslashes()
     * @see addcslashes()
     * @see stripslashes()
     * @see stripcslashes()
     * @see quotemeta()
     * @see mysqli_real_escape_string()
     * @see PDO::quote()
     * @see var_export()
     * @see json_encode()
     */
    public static function toRawSql(QueryExecuted $queryExecuted): string
    {
        if (method_exists($queryExecuted, 'toRawSql')) {
            return $queryExecuted->toRawSql(); // @codeCoverageIgnore
        }

        return $queryExecuted->connection
            ->query()
            ->getGrammar()
            ->substituteBindingsIntoRawSql(
                $queryExecuted->sql,
                $queryExecuted->connection->prepareBindings($queryExecuted->bindings)
            );
    }
}

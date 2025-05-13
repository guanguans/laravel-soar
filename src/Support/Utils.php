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

use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\Relation as RelationBuilder;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Database\Query\Builder as QueryBuilder;
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
                str_replace(base_path().\DIRECTORY_SEPARATOR, '', $trace['file']),
                $trace['line']
            ))
            ->values()
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

    public static function toRawSql(EloquentBuilder|QueryBuilder|QueryExecuted|RelationBuilder $query): string
    {
        if (method_exists($query, 'toRawSql')) {
            return $query->toRawSql(); // @codeCoverageIgnore
        }

        if ($query instanceof QueryExecuted) {
            $sql = $query->sql;
            $bindings = $query->bindings;
            $connection = $query->connection;
        } else {
            $sql = $query->toSql();
            $bindings = $query->getBindings();
            $connection = $query->getConnection();
        }

        if ([] === $bindings) {
            return $sql;
        }

        return self::replaceSqlBindings($sql, $bindings, $connection);
    }

    /**
     * @noinspection DebugFunctionUsageInspection
     *
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
    public static function replaceSqlBindings(string $sql, array $bindings, Connection $connection): string
    {
        // $quoteStringBinding = static function (mixed $pdo, mixed $binding): string {
        //     try {
        //         if ($pdo instanceof \PDO) {
        //             return $pdo->quote($binding);
        //         }
        //     } catch (\PDOException $pdoException) {
        //         throw_if('IM001' !== $pdoException->getCode(), $pdoException);
        //     }
        //
        //     // Fallback when PDO::quote function is missing...
        //     $binding = strtr($binding, [
        //         \chr(26) => '\\Z',
        //         \chr(8) => '\\b',
        //         '"' => '\"',
        //         "'" => "\\'",
        //         '\\' => '\\\\',
        //     ]);
        //
        //     return "'".$binding."'";
        // };
        //
        // return collect($connection->prepareBindings($bindings))->reduce(
        //     static function (string $sql, mixed $binding, mixed $key) use ($quoteStringBinding, $connection): string {
        //         if (null === $binding) {
        //             $binding = 'null';
        //         } elseif (!\is_int($binding) && !\is_float($binding)) {
        //             $binding = $quoteStringBinding($connection->getPdo(), $binding);
        //         }
        //
        //         return preg_replace(
        //             is_numeric($key)
        //                 ? "/\\?(?=(?:[^'\\\\']*'[^'\\\\']*')*[^'\\\\']*$)/"
        //                 : "/:$key(?=(?:[^'\\\\']*'[^'\\\\']*')*[^'\\\\']*$)/",
        //             (string) $binding,
        //             $sql,
        //             is_numeric($key) ? 1 : -1
        //         );
        //     },
        //     $sql,
        // );

        return vsprintf(
            str_replace(['%', '?', '%s%s'], ['%%', '%s', '?'], $sql),
            array_map(
                static fn (mixed $binding): string => \is_string($binding)
                    ? $connection->getPdo()->quote($binding)
                    : var_export($binding, true),
                $connection->prepareBindings($bindings)
            )
        );
    }
}

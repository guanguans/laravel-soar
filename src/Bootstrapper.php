<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelSoar;

use Guanguans\LaravelSoar\Http\Middleware\OutputSoarScoresMiddleware;
use Illuminate\Console\Events\CommandFinished;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Bootstrapper
{
    protected Container $container;
    protected bool $booted = false;

    protected static Collection $queries;
    protected static Collection $scores;

    public function __construct(Container $container)
    {
        $this->container = $container;
        self::$queries = collect();
        self::$scores = collect();
    }

    public function isBooted(): bool
    {
        return $this->booted;
    }

    /**
     * @throws BindingResolutionException
     *
     * @noinspection OffsetOperationsInspection
     */
    public function boot(): void
    {
        if ($this->booted) {
            return;
        }

        $this->booted = true;
        $this->logQuery($this->container['events']);
        $this->registerOutputMonitor($this->container);
    }

    public function getScores(): Collection
    {
        if (self::$scores->isEmpty()) {
            self::$scores = $this->toScores(self::$queries)
                ->sortBy('Score')
                ->map(function (array $score): array {
                    $query = $this->matchQuery(self::$queries, $score);

                    return [
                        'Summary' => sprintf(
                            '[%s|%d分|%s|%s]',
                            $star = to_star($score['Score']),
                            $score['Score'],
                            $query['time'],
                            $query['sql']
                        ),
                        'Basic' => [
                            'Sample' => $query['sql'],
                            'Score' => $score['Score'],
                            'Star' => $star,
                            'Time' => $query['time'],
                            'Connection' => $query['connection'],
                            'Driver' => $query['driver'],
                            'Tables' => (array) $score['Tables'],
                        ],
                        'HeuristicRules' => (array) $score['HeuristicRules'],
                        'IndexRules' => (array) $score['IndexRules'],
                        'Explain' => $this->sanitizeExplain((array) $score['Explain']),
                        'Backtraces' => $query['backtraces'],
                    ];
                })
                ->values();
        }

        return self::$scores;
    }

    protected function logQuery(Dispatcher $dispatcher): void
    {
        // 记录 SQL
        $dispatcher->listen(QueryExecuted::class, function (QueryExecuted $queryExecuted): void {
            if (
                isset(self::$queries[$queryExecuted->sql])
                || $this->isExceptSql($queryExecuted->sql)
                || $this->isExceptSql($sql = $this->toSql($queryExecuted))
            ) {
                return;
            }

            self::$queries[$queryExecuted->sql] = [
                'sql' => $sql,
                'time' => to_human_time($queryExecuted->time),
                'connection' => $queryExecuted->connectionName,
                'driver' => $queryExecuted->connection->getDriverName(),
                'backtraces' => $this->getBacktraces(),
            ];
        });
    }

    protected function isExceptSql(string $sql): bool
    {
        return Str::is(config('soar.except', []), $sql);
    }

    protected function toSql(QueryExecuted $queryExecuted): string
    {
        if ([] === $queryExecuted->bindings) {
            return $queryExecuted->sql;
        }

        $sqlWithPlaceholders = str_replace(['%', '?', '%s%s'], ['%%', '%s', '?'], $queryExecuted->sql);
        $bindings = $queryExecuted->connection->prepareBindings($queryExecuted->bindings);
        $pdo = $queryExecuted->connection->getPdo();

        return vsprintf($sqlWithPlaceholders, array_map(
            static fn ($binding): string => null === $binding ? 'NULL' : $pdo->quote($binding),
            $bindings
        ));
    }

    /**
     * @noinspection DebugFunctionUsageInspection
     */
    protected function getBacktraces(int $limit = 0, int $forgetLines = 0): array
    {
        return collect(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, $limit))
            ->forget($forgetLines)
            ->filter(
                static fn ($trace): bool => isset($trace['file'], $trace['line'])
                    && ! Str::contains($trace['file'], 'vendor')
            )
            ->map(static fn ($trace, $index): string => sprintf(
                '#%s %s:%s',
                $index,
                str_replace(base_path(), '', $trace['file']),
                $trace['line']
            ))
            ->values()
            ->all();
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @noinspection PhpUndefinedMethodInspection
     * @noinspection OffsetOperationsInspection
     */
    protected function registerOutputMonitor(Container $app): void
    {
        // 注册输出监听
        $app['events']->listen(
            CommandFinished::class,
            fn (CommandFinished $commandFinished) => $app->make(OutputManager::class)->output(
                $this->getScores(),
                $commandFinished
            )
        );

        // 注册输出中间件
        is_lumen()
            ? $app->middleware(OutputSoarScoresMiddleware::class) // @codeCoverageIgnore
            : $app->make(Kernel::class)->pushMiddleware(OutputSoarScoresMiddleware::class);
    }

    protected function toScores(Collection $queries): Collection
    {
        return $queries
            ->map(static fn (array $query): string => $query['sql'])
            ->pipe(static fn (Collection $sqls): Collection => collect(app(Soar::class)->arrayScores($sqls->all())));
    }

    /**
     * @return array{
     *     sql: string,
     *     time: string,
     *     connection: string,
     *     driver: string,
     *     backtraces: array<string>
     * }
     */
    protected function matchQuery(Collection $queries, array $score): array
    {
        $query = $queries->first(static fn ($query): bool => $score['Sample'] === $query['sql']);
        if ($query) {
            return $query;
        }

        // @codeCoverageIgnoreStart
        return $queries
            ->map(static function (array $query) use ($score): array {
                $query['similarity'] = similar_text($score['Sample'], $query['sql']);

                return $query;
            })
            ->sortByDesc('similarity')
            ->first();
        // @codeCoverageIgnoreEnd
    }

    protected function sanitizeExplain(array $explain): array
    {
        return collect($explain)
            ->map(static function (array $explain): array {
                $explain['Content'] = collect(explode(PHP_EOL, $explain['Content']))->filter()->values()->all();
                $explain['Case'] = collect(explode(PHP_EOL, $explain['Case']))->filter()->values()->all();

                return $explain;
            })
            ->all();
    }
}

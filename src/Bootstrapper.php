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

namespace Guanguans\LaravelSoar;

use Guanguans\LaravelSoar\Middleware\OutputSoarScoresMiddleware;
use Illuminate\Console\Events\CommandFinished;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use function Guanguans\LaravelSoar\Support\humanly_milliseconds;
use function Guanguans\LaravelSoar\Support\star_for;

class Bootstrapper
{
    protected bool $booted = false;
    protected static Collection $queries;
    protected static Collection $scores;

    public function __construct(protected Container $container)
    {
        self::$queries = collect();
        self::$scores = collect();
    }

    public function isBooted(): bool
    {
        return $this->booted;
    }

    /**
     * @noinspection OffsetOperationsInspection
     *
     * @throws BindingResolutionException
     */
    public function boot(): void
    {
        if ($this->booted) {
            return;
        }

        $this->booted = true;
        $this->logQuery($this->container->make(\Illuminate\Contracts\Events\Dispatcher::class));
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
                        'Summary' => \sprintf(
                            '[%s|%d分|%s|%s]',
                            $star = star_for($score['Score']),
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
                self::$queries->has($queryExecuted->sql)
                || $this->isExceptSql($queryExecuted->sql)
                || $this->isExceptSql($sql = $this->toSql($queryExecuted))
            ) {
                return;
            }

            self::$queries->put($queryExecuted->sql, [
                'sql' => $sql,
                'time' => humanly_milliseconds($queryExecuted->time),
                'connection' => $queryExecuted->connectionName,
                'driver' => $queryExecuted->connection->getDriverName(),
                'backtraces' => $this->getBacktraces(),
            ]);
        });
    }

    protected function isExceptSql(string $sql): bool
    {
        return Str::is(config('soar.except', []), $sql);
    }

    /**
     * @noinspection DebugFunctionUsageInspection
     */
    protected function toSql(QueryExecuted $queryExecuted): string
    {
        if ([] === $queryExecuted->bindings) {
            return $queryExecuted->sql;
        }

        $sqlWithPlaceholders = str_replace(['%', '?', '%s%s'], ['%%', '%s', '?'], $queryExecuted->sql);
        $bindings = $queryExecuted->connection->prepareBindings($queryExecuted->bindings);
        $pdo = $queryExecuted->connection->getPdo();

        return vsprintf($sqlWithPlaceholders, array_map(
            static fn ($binding): string => \is_string($binding) ? $pdo->quote($binding) : var_export($binding, true),
            $bindings
        ));
    }

    /**
     * @noinspection DebugFunctionUsageInspection
     */
    protected function getBacktraces(int $limit = 0, int $forgetLines = 0): array
    {
        return collect(debug_backtrace(\DEBUG_BACKTRACE_IGNORE_ARGS, $limit))
            ->forget($forgetLines)
            ->filter(
                static fn ($trace): bool => isset($trace['file'], $trace['line'])
                    && !Str::contains($trace['file'], 'vendor')
            )
            ->map(static fn ($trace, $index): string => \sprintf(
                '#%s %s:%s',
                $index,
                str_replace(base_path(), '', $trace['file']),
                $trace['line']
            ))
            ->values()
            ->all();
    }

    /**
     * @noinspection PhpUndefinedMethodInspection
     * @noinspection OffsetOperationsInspection
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function registerOutputMonitor(Container $container): void
    {
        // 注册输出监听
        $container->make(\Illuminate\Contracts\Events\Dispatcher::class)->listen(
            CommandFinished::class,
            fn (CommandFinished $commandFinished) => $container->make(OutputManager::class)->output(
                $this->getScores(),
                $commandFinished
            )
        );

        // 注册输出中间件
        $container->make(Kernel::class)->pushMiddleware(OutputSoarScoresMiddleware::class);
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
                $explain['Content'] = collect(explode(\PHP_EOL, $explain['Content']))->filter()->values()->all();
                $explain['Case'] = collect(explode(\PHP_EOL, $explain['Case']))->filter()->values()->all();

                return $explain;
            })
            ->all();
    }
}

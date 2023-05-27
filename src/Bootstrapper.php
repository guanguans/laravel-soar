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

use Guanguans\LaravelSoar\Http\Middleware\OutputSoarScoreMiddleware;
use Illuminate\Console\Events\CommandFinished;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Bootstrapper
{
    protected Collection $queries;

    protected Collection $scores;

    protected bool $booted = false;

    public function __construct()
    {
        $this->queries = collect();
        $this->scores = collect();
    }

    public function bootIf($condition, Container $app): void
    {
        value($condition) and $this->boot($app);
    }

    public function boot(Container $app): void
    {
        if ($this->booted) {
            return;
        }

        $this->booted = true;
        $this->logQuery($app['events']);
        $this->registerOutputMonitor($app);
    }

    public function isBooted(): bool
    {
        return $this->booted;
    }

    public function isEnabled(): bool
    {
        return config('soar.enabled');
    }

    public function isExcludedSql(string $sql): bool
    {
        return Str::is(config('soar.except'), $sql);
    }

    public function getScores(): Collection
    {
        $this->scores->isEmpty() and $this->scores = $this->transformToScores($this->queries)
            ->sortBy('Score')
            ->map(function (array $score): array {
                $query = $this->matchQuery($this->queries, $score);

                return [
                    'Summary' => sprintf('[%s|%d分|%s|%s]', $star = score_to_star($score['Score']), $score['Score'], $query['time'], $query['sql']),
                    'HeuristicRules' => (array) $score['HeuristicRules'],
                    'IndexRules' => (array) $score['IndexRules'],
                    'Explain' => $this->formatExplain($score['Explain']),
                    'Backtraces' => $query['backtraces'],
                    'Basic' => [
                        'Sample' => $query['sql'],
                        'Score' => $score['Score'],
                        'Star' => $star,
                        'Time' => $query['time'],
                        'Connection' => $query['connection'],
                        'Driver' => $query['driver'],
                        'Tables' => (array) $score['Tables'],
                    ],
                ];
            })
            ->values();

        return $this->scores;
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
    public function matchQuery(Collection $queries, array $score): array
    {
        $query = (array) $queries->first(static fn ($query): bool => $score['Sample'] === $query['sql']);

        $query or $query = $queries
            ->map(static function ($query) use ($score) {
                $query['similarity'] = similar_text($score['Sample'], $query['sql']);

                return $query;
            })
            ->sortByDesc('similarity')
            ->first();

        return $query;
    }

    public function formatExplain(?array $explain): array
    {
        if (null === $explain) {
            return [];
        }

        $explain = $explain[0] ?? $explain;
        $explain['Content'] = array_values(array_filter(explode("\n", $explain['Content'])));
        $explain['Case'] = explode("\n", $explain['Case']);

        return $explain;
    }

    protected function transformToSql(QueryExecuted $queryExecutedEvent): string
    {
        if (empty($queryExecutedEvent->bindings)) {
            return $queryExecutedEvent->sql;
        }

        $sqlWithPlaceholders = str_replace(['%', '?', '%s%s'], ['%%', '%s', '?'], $queryExecutedEvent->sql);
        $bindings = $queryExecutedEvent->connection->prepareBindings($queryExecutedEvent->bindings);
        $pdo = $queryExecutedEvent->connection->getPdo();

        return vsprintf($sqlWithPlaceholders, array_map([$pdo, 'quote'], $bindings));
    }

    protected function transformToHumanTime(float $milliseconds): string
    {
        if ($milliseconds < 1) {
            return round($milliseconds * 1000).'μs';
        }

        if ($milliseconds < 1000) {
            return round($milliseconds, 2).'ms';
        }

        return round($milliseconds / 1000, 2).'s';
    }

    /**
     * @noinspection DebugFunctionUsageInspection
     */
    protected function getBacktraces(int $limit = 0, int $forgetLines = 0): array
    {
        return collect(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, $limit))
            ->forget($forgetLines)
            ->filter(static fn ($trace): bool => isset($trace['file']) && isset($trace['line']) && ! Str::contains($trace['file'], 'vendor'))
            ->map(static fn ($trace, $index): string => sprintf('#%s %s:%s', $index, str_replace(base_path(), '', $trace['file']), $trace['line']))
            ->values()
            ->all();
    }

    protected function transformToScores(Collection $queries): Collection
    {
        return $queries->pipe(static function (Collection $queries): Collection {
            $sql = $queries->reduce(static fn ($sql, $query): string => $sql.$query['sql'].'; ', '');

            return collect(app('soar')->arrayScores($sql));
        });
    }

    protected function logQuery(Dispatcher $dispatcher): void
    {
        // 记录 SQL
        $dispatcher->listen(QueryExecuted::class, function (QueryExecuted $queryExecuted): void {
            if (
                isset($this->queries[$queryExecuted->sql])
                || $this->isExcludedSql($queryExecuted->sql)
                || $this->isExcludedSql($sql = $this->transformToSql($queryExecuted))
            ) {
                return;
            }

            $this->queries[$queryExecuted->sql] = [
                'sql' => $sql,
                'time' => $this->transformToHumanTime($queryExecuted->time),
                'connection' => $queryExecuted->connectionName,
                'driver' => $queryExecuted->connection->getDriverName(),
                'backtraces' => $this->getBacktraces(),
            ];
        });
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function registerOutputMonitor(Container $app): void
    {
        // 注册输出监听
        $app['events']->listen(CommandFinished::class, function (CommandFinished $commandFinished) use ($app): void {
            $app->make(OutputManager::class)->output($this->getScores(), $commandFinished);
        });

        // 注册输出中间件
        is_lumen()
        ? $app->middleware(OutputSoarScoreMiddleware::class)
        : $app->make(Kernel::class)->pushMiddleware(OutputSoarScoreMiddleware::class);
    }
}

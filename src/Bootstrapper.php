<?php

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelSoar;

use Guanguans\LaravelSoar\Facades\Soar;
use Guanguans\LaravelSoar\Middleware\OutputSoarScoreMiddleware;
use Illuminate\Console\Events\CommandFinished;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Foundation\Http\Events\RequestHandled;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;

class Bootstrapper
{
    /**
     * @var \Illuminate\Support\Collection|null
     */
    protected $scores;

    /**
     * @var array
     */
    protected $queries = [];

    /**
     * @var bool
     */
    protected $booted = false;

    /**
     * @param mixed $condition
     */
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

        DB::listen(function (QueryExecuted $queryExecutedEvent) {
            if ($this->isExcludedSql($sql = $this->transformToSql($queryExecutedEvent))) {
                return;
            }

            $this->queries[$queryExecutedEvent->sql] = [
                'sql' => $sql,
                'time' => $this->transformToHumanTime($queryExecutedEvent->time),
                'connection' => $queryExecutedEvent->connectionName,
                'driver' => $queryExecutedEvent->connection->getDriverName(),
                'backtraces' => $this->getBacktraces(),
            ];
        });

        Event::listen([
            RequestHandled::class,
            CommandFinished::class,
        ], function ($event) use ($app) {
            $app->make(OutputManager::class)->output($this->getScores(), $event);
        });

        $app->make(Kernel::class)->pushMiddleware(OutputSoarScoreMiddleware::class);
    }

    public function isBooted(): bool
    {
        return $this->booted;
    }

    public function isEnabledSoarScore(): bool
    {
        return config('soar.enabled');
    }

    public function isExcludedSql(string $sql): bool
    {
        return Str::is(config('soar.except'), $sql);
    }

    public function getScores(): Collection
    {
        $this->scores or $this->scores = collect($this->queries)
            ->pipe(function (Collection $queries) {
                $sql = $queries->reduce(function ($sql, $query) {
                    return $sql.$query['sql'].'; ';
                }, '');

                return collect(Soar::arrayScore($sql));
            })
            ->sortBy('Score')
            ->map(function (array $score) {
                $query = (array) collect($this->queries)->first(function ($query) use ($score) {
                    return $score['Sample'] === str_replace(['`', '"'], ['', "'"], $query['sql']);
                });

                $star = str_repeat('★', $good = round($score['Score'] / 100 * 5)).str_repeat('☆', 5 - $good);

                return [
                    'Summary' => sprintf('%s|%d分|%s|%s', $star, $score['Score'], $query['time'], $query['sql']),
                    'HeuristicRules' => (array) $score['HeuristicRules'],
                    'IndexRules' => (array) $score['IndexRules'],
                    'Explain' => $score['Explain'][0] ?? $score['Explain'] ?? [],
                    'Backtraces' => $this->getBacktraces(),
                    'Basic' => [
                        'ID' => $score['ID'],
                        'Fingerprint' => $score['Fingerprint'],
                        'Sample' => $query['sql'],
                        'Score' => $score['Score'],
                        'Star' => $star,
                        'Level' => $score['Score'] >= 80 ? 'info' : ($score['Score'] >= 60 ? 'warning' : 'critical'),
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

    protected function getBacktraces(int $limit = 0, int $forgetLines = 0): array
    {
        return collect(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, $limit))
            ->forget($forgetLines)
            ->filter(function ($trace) {
                return isset($trace['file']) && isset($trace['line']) && ! Str::contains($trace['file'], 'vendor');
            })
            ->map(function ($trace, $index) {
                return sprintf('#%s %s(%s)', $index, str_replace(base_path(), '', $trace['file']), $trace['line']);
            })
            ->values()
            ->all();
    }
}

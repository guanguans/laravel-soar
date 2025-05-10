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

use Guanguans\LaravelSoar\Middleware\OutputScoresMiddleware;
use Illuminate\Console\Events\CommandFinished;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Foundation\Application;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;
use function Guanguans\LaravelSoar\Support\humanly_milliseconds;
use function Guanguans\LaravelSoar\Support\star_for;

class Bootstrapper
{
    private bool $booted = false;
    private static Collection $queries;
    private static Collection $scores;

    public function __construct(private Application $application)
    {
        self::$queries = collect();
        self::$scores = collect();
    }

    public function boot(): void
    {
        if ($this->booted) {
            return;
        }

        $this->booted = true;
        $this->logQueries();
        $this->registerOutputMonitor();
    }

    /**
     * @throws \JsonException
     */
    public function getScores(): Collection
    {
        return self::$scores = self::$scores->whenEmpty(
            fn () => $this->toScores()
                ->sortBy(['Score', 'Fingerprint'])
                ->map(fn (array $score): array => $this->hydrateScore($score))
                ->values()
        );
    }

    /**
     * @throws \JsonException
     */
    private function toScores(): Collection
    {
        return self::$queries
            ->pluck('sql')
            ->pipe(static fn (Collection $queries): Collection => collect(
                resolve(Soar::class)->arrayScores($queries->all())
            ));
    }

    private function hydrateScore(array $score): array
    {
        $query = $this->matchQuery($score);

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
    private function matchQuery(array $score): array
    {
        return self::$queries->first(
            static fn (array $query): bool => $score['Sample'] === $query['sql'],
            static fn (): array => self::$queries
                ->map(static function (array $query) use ($score): array {
                    $query['similarity'] = similar_text($score['Sample'], $query['sql']);

                    return $query;
                })
                ->sortByDesc('similarity')
                ->first()
        );
    }

    private function sanitizeExplain(array $explain): array
    {
        return collect($explain)
            ->map(static function (array $explain): array {
                $explain['Content'] = str($explain['Content'])->explode(\PHP_EOL)->filter()->values()->all();
                $explain['Case'] = str($explain['Case'])->explode(\PHP_EOL)->filter()->values()->all();

                return $explain;
            })
            ->all();
    }

    private function logQueries(): void
    {
        Event::listen(QueryExecuted::class, function (QueryExecuted $queryExecuted): void {
            if (
                self::$queries->has($queryExecuted->sql)
                || $this->isExceptQuery($queryExecuted->sql)
                || $this->isExceptQuery($sql = $this->toRawSql($queryExecuted))
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

    private function isExceptQuery(string $query): bool
    {
        return Str::is(config('soar.except_queries', []), $query);
    }

    /**
     * @noinspection DebugFunctionUsageInspection
     */
    private function toRawSql(QueryExecuted $queryExecuted): string
    {
        if (method_exists($queryExecuted, 'toRawSql')) {
            return $queryExecuted->toRawSql();
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
     */
    private function getBacktraces(int $limit = 0, int $forgetLines = 0): array
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

    private function registerOutputMonitor(): void
    {
        Event::listen(
            CommandFinished::class,
            fn (CommandFinished $commandFinished) => $this
                ->application
                ->make(OutputManager::class)
                ->output($this->getScores(), $commandFinished)
        );

        $this->application->make(Kernel::class)->prependMiddleware(OutputScoresMiddleware::class);
    }
}

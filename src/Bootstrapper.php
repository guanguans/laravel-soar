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

use Guanguans\LaravelSoar\Listeners\OutputScoresListener;
use Guanguans\LaravelSoar\Middleware\OutputScoresMiddleware;
use Guanguans\LaravelSoar\Support\Utils;
use Illuminate\Console\Events\CommandFinished;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Foundation\Application;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Event;
use function Guanguans\LaravelSoar\Support\humanly_milliseconds;

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
        $this->registerOutputter();
    }

    /**
     * @throws \JsonException
     */
    public function getScores(): Collection
    {
        return self::$scores = self::$scores->whenEmpty(
            fn () => $this->toOriginalScores()
                ->sortBy(['Score', 'Fingerprint'])
                ->map(fn (array $score): array => $this->hydrateScore($score))
                ->values()
        );
    }

    private function logQueries(): void
    {
        Event::listen(QueryExecuted::class, static function (QueryExecuted $queryExecuted): void {
            if (
                self::$queries->has($queryExecuted->sql)
                || Utils::isExceptQuery($queryExecuted->sql)
                || Utils::isExceptQuery($sql = Utils::toRawSql($queryExecuted))
            ) {
                return;
            }

            self::$queries->put($queryExecuted->sql, [
                'sql' => $sql,
                'time' => humanly_milliseconds($queryExecuted->time),
                'connection' => $queryExecuted->connectionName,
                'driver' => $queryExecuted->connection->getDriverName(),
                'backtraces' => Utils::backtraces(),
            ]);
        });
    }

    private function registerOutputter(): void
    {
        Event::listen(CommandFinished::class, OutputScoresListener::class);
        $this->application->make(Kernel::class)->prependMiddleware(OutputScoresMiddleware::class);
    }

    private function toOriginalScores(): Collection
    {
        return self::$queries->whenNotEmpty(static fn (Collection $queries): Collection => collect(
            resolve(Soar::class)->arrayScores($queries->pluck('sql')->all())
        ));
    }

    private function hydrateScore(array $score): array
    {
        $query = $this->matchQuery($score);

        return [
            'Summary' => \sprintf(
                '[%s|%d分|%s|%s]',
                $star = Utils::star($score['Score']),
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
            'Explain' => Utils::sanitizeExplain($score['Explain']),
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
}

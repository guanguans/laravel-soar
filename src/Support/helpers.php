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

use Carbon\CarbonInterval;
use Composer\Autoload\ClassLoader;
use Illuminate\Support\Collection;

if (!\function_exists('Guanguans\LaravelSoar\Support\classes')) {
    /**
     * @see https://github.com/illuminate/collections
     * @see https://github.com/alekitto/class-finder
     * @see https://github.com/ergebnis/classy
     * @see https://gitlab.com/hpierce1102/ClassFinder
     * @see https://packagist.org/packages/haydenpierce/class-finder
     * @see \get_declared_classes()
     * @see \get_declared_interfaces()
     * @see \get_declared_traits()
     * @see \DG\BypassFinals::enable()
     * @see \Composer\Util\ErrorHandler
     * @see \Monolog\ErrorHandler
     * @see \PhpCsFixer\ExecutorWithoutErrorHandler
     * @see \Phrity\Util\ErrorHandler
     *
     * @noinspection RedundantDocCommentTagInspection
     * @noinspection PhpUndefinedNamespaceInspection
     *
     * @param null|(callable(class-string, string): bool) $filter
     *
     * @return \Illuminate\Support\Collection<class-string, \ReflectionClass>
     */
    function classes(?callable $filter = null): Collection
    {
        static $classes;

        $classes ??= collect(spl_autoload_functions())->flatMap(
            static fn (mixed $loader): array => \is_array($loader) && $loader[0] instanceof ClassLoader
                ? $loader[0]->getClassMap()
                : []
        );

        return $classes
            ->when(
                \is_callable($filter),
                static fn (Collection $classes): Collection => $classes->filter(
                    static fn (string $file, string $class) => $filter($class, $file)
                )
            )
            ->mapWithKeys(static function (string $file, string $class): array {
                try {
                    return [$class => new \ReflectionClass($class)];
                } catch (\Throwable $throwable) {
                    return [$class => $throwable];
                }
            });
    }
}

if (!\function_exists('Guanguans\LaravelSoar\Support\env_explode')) {
    /**
     * @noinspection LaravelFunctionsInspection
     */
    function env_explode(string $key, mixed $default = null, string $delimiter = ',', int $limit = \PHP_INT_MAX): mixed
    {
        $env = env($key, $default);

        if (\is_string($env)) {
            return $env ? explode($delimiter, $env, $limit) : [];
        }

        return $env;
    }
}

if (!\function_exists('Guanguans\LaravelSoar\Support\human_milliseconds')) {
    /**
     * @noinspection PhpUnhandledExceptionInspection
     */
    function human_milliseconds(float|int $milliseconds, array $syntax = []): string
    {
        return CarbonInterval::microseconds($milliseconds * 1000)
            ->cascade()
            ->forHumans($syntax + [
                'join' => ', ',
                'locale' => 'en',
                // 'locale' => 'zh_CN',
                'minimumUnit' => 'us',
                'short' => true,
            ]);
    }
}

if (!\function_exists('Guanguans\LaravelSoar\Support\json_pretty_encode')) {
    /**
     * @param int<1, 4194304> $depth
     *
     * @throws \JsonException
     */
    function json_pretty_encode(mixed $value, int $options = 0, int $depth = 512): string
    {
        return json_encode(
            $value,
            \JSON_PRETTY_PRINT | \JSON_UNESCAPED_UNICODE | \JSON_UNESCAPED_SLASHES | \JSON_THROW_ON_ERROR | $options,
            $depth
        );
    }
}

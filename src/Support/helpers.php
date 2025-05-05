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

if (!\function_exists('var_output')) {
    /**
     * @noinspection DebugFunctionUsageInspection
     */
    function var_output(mixed $expression, bool $return = false): ?string
    {
        $patterns = [
            "/array \\(\n\\)/" => '[]',
            "/array \\(\n\\s+\\)/" => '[]',
            '/array \(/' => '[',
            '/^([ ]*)\)(,?)$/m' => '$1]$2',
            "/=>[ ]?\n[ ]+\\[/" => '=> [',
            "/([ ]*)(\\'[^\\']+\\') => ([\\[\\'])/" => '$1$2 => $3',
        ];

        $export = var_export($expression, true);
        $export = preg_replace(array_keys($patterns), array_values($patterns), $export);

        if ($return) {
            return $export;
        }

        echo $export;

        return null;
    }
}

if (!\function_exists('array_reduce_with_keys')) {
    /**
     * @return null|mixed
     *
     * @codeCoverageIgnore
     */
    function array_reduce_with_keys(array $array, callable $callback, mixed $carry = null): mixed
    {
        foreach ($array as $key => $value) {
            $carry = $callback($carry, $value, $key);
        }

        return $carry;
    }
}

if (!\function_exists('to_star')) {
    function to_star(int $score): string
    {
        return str_repeat('★', $good = (int) round($score / 100 * 5)).str_repeat('☆', 5 - $good);
    }
}

if (!\function_exists('to_human_time')) {
    function to_human_time(float $milliseconds): string
    {
        if (1 > $milliseconds) {
            return round($milliseconds * 1000).'μs';
        }

        if (1000 > $milliseconds) {
            return round($milliseconds, 2).'ms';
        }

        return round($milliseconds / 1000, 2).'s';
    }
}

if (!\function_exists('to_pretty_json')) {
    /**
     * @throws JsonException
     */
    function to_pretty_json(array $score, int $options = 0, int $depth = 512): string
    {
        return json_encode(
            $score,
            \JSON_PRETTY_PRINT | \JSON_UNESCAPED_UNICODE | \JSON_UNESCAPED_SLASHES | \JSON_THROW_ON_ERROR | $options,
            $depth
        );
    }
}

if (!\function_exists('base64_encode_file')) {
    function base64_encode_file(string $filename): string
    {
        return base64_encode(file_get_contents($filename));
    }
}

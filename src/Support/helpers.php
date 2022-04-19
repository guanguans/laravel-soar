<?php

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Guanguans\SoarPHP\Support\OsHelper;
use Illuminate\Contracts\Container\Container;
use Laravel\Lumen\Application as LumenApplication;

if (! function_exists('soar')) {
    /**
     * @return \Guanguans\LaravelSoar\Soar
     */
    function soar()
    {
        app('soar');
    }
}

if (! function_exists('var_output')) {
    /**
     * @param $expression
     *
     * @return string|void|null
     */
    function var_output($expression, bool $return = false)
    {
        $patterns = [
            "/array \(\n\)/" => '[]',
            "/array \(\n\s+\)/" => '[]',
            "/array \(/" => '[',
            "/^([ ]*)\)(,?)$/m" => '$1]$2',
            "/=>[ ]?\n[ ]+\[/" => '=> [',
            "/([ ]*)(\'[^\']+\') => ([\[\'])/" => '$1$2 => $3',
        ];

        $export = var_export($expression, true);
        $export = preg_replace(array_keys($patterns), array_values($patterns), $export);
        if ($return) {
            return $export;
        }

        echo $export;
    }
}

if (! function_exists('array_reduces')) {
    /**
     * @param $carry
     *
     * @return mixed|null
     */
    function array_reduces(array $array, callable $callback, $carry = null)
    {
        foreach ($array as $key => $value) {
            $carry = call_user_func($callback, $carry, $value, $key);
        }

        return $carry;
    }
}

if (! function_exists('score_to_star')) {
    function score_to_star(int $score): string
    {
        return str_repeat('★', $good = round($score / 100 * 5)).str_repeat('☆', 5 - $good);
    }
}

if (! function_exists('to_pretty_json')) {
    function to_pretty_json(
        array $score,
        int $options = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES,
        int $depth = 512
    ): string {
        return json_encode($score, $options | JSON_PRETTY_PRINT, $depth);
    }
}

if (! function_exists('normalize_sql')) {
    function normalize_sql(string $sql): string
    {
        if (OsHelper::isWindows()) {
            return str_replace(['`', '"'], ['', ''], $sql);
        }

        return str_replace(['`', '"'], ['\`', '\"'], $sql);
    }
}

if (! function_exists('is_lumen')) {
    function is_lumen(?Container $app = null): bool
    {
        $app = $app ?: app();

        return $app instanceof LumenApplication;
    }
}

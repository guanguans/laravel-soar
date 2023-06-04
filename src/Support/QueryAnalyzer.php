<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelSoar\Support;

class QueryAnalyzer
{
    /**
     * KEYWORDS1.
     */
    public const KEYWORDS1 = 'SELECT|(?:ON\s+DUPLICATE\s+KEY)?UPDATE|INSERT(?:\s+INTO)?|REPLACE(?:\s+INTO)?|DELETE|CALL|UNION|FROM|WHERE|HAVING|GROUP\s+BY|ORDER\s+BY|LIMIT|OFFSET|SET|VALUES|LEFT\s+JOIN|INNER\s+JOIN|TRUNCATE';

    /**
     * KEYWORDS2.
     */
    public const KEYWORDS2 = 'ALL|DISTINCT|DISTINCTROW|IGNORE|AS|USING|ON|AND|OR|IN|IS|NOT|NULL|[RI]?LIKE|REGEXP|TRUE|FALSE';

    /**
     * Returns syntax highlighted SQL.
     */
    public static function highlight(string $sql, array $bindings = [], ?\PDO $pdo = null): string
    {
        // insert new lines
        $sql = " $sql ";
        $sql = preg_replace('#(?<=[\\s,(])('.static::KEYWORDS1.')(?=[\\s,)])#i', "\n\$1", $sql);

        // reduce spaces
        $sql = preg_replace('#[ \t]{2,}#', ' ', $sql);

        // syntax highlight
        $sql = htmlspecialchars($sql, ENT_IGNORE);
        $sql = preg_replace_callback(
            '#(/\\*.+?\\*/)|(\\*\\*.+?\\*\\*)|(?<=[\\s,(])('.static::KEYWORDS1.')(?=[\\s,)])|(?<=[\\s,(=])('.static::KEYWORDS2.')(?=[\\s,)=])#is',
            static function ($matches) {
                if (! empty($matches[1])) { // comment
                    return '<em style="color:gray">'.$matches[1].'</em>';
                }

                if (! empty($matches[2])) { // error
                    return '<strong style="color:red">'.$matches[2].'</strong>';
                }

                if (! empty($matches[3])) { // most important keywords
                    return '<strong style="color:blue; text-transform: uppercase;">'.$matches[3].'</strong>';
                }

                if (! empty($matches[4])) { // other keywords
                    return '<strong style="color:green">'.$matches[4].'</strong>';
                }
            },
            $sql
        );

        $bindings = array_map(static function ($binding) use ($pdo): string {
            if (\is_array($binding)) {
                $binding = implode(', ', array_map(static fn ($value) => \is_string($value) ? htmlspecialchars("'".$value."'", ENT_NOQUOTES) : $value, $binding));

                return htmlspecialchars('('.$binding.')', ENT_NOQUOTES);
            }

            if (\is_string($binding) && (preg_match('#[^\x09\x0A\x0D\x20-\x7E\xA0-\x{10FFFF}]#u', $binding) || preg_last_error())) {
                return '<i title="Length '.\strlen($binding).' bytes">&lt;binary&gt;</i>';
            }

            if (\is_string($binding)) {
                $text = htmlspecialchars($pdo instanceof \PDO ? $pdo->quote($binding) : "'".$binding."'", ENT_NOQUOTES);

                return '<span title="Length '.\strlen($text).' characters">'.$text.'</span>';
            }

            $info = [];
            if (\is_resource($binding)) {
                $type = get_resource_type($binding);
                if ('stream' === $type) {
                    $info = stream_get_meta_data($binding);
                }

                return '<i'.(isset($info['uri']) ? ' title="'.htmlspecialchars($info['uri'], ENT_NOQUOTES).'"' : null)
                       .'>&lt;'.htmlspecialchars($type, ENT_NOQUOTES).' resource&gt;</i>';
            }

            if ($binding instanceof \DateTimeImmutable) {
                return htmlspecialchars("'".$binding->format('Y-m-d H:i:s')."'", ENT_NOQUOTES);
            }

            return htmlspecialchars($binding, ENT_NOQUOTES);
        }, $bindings);

        $sql = str_replace(['%', '?'], ['%%', '%s'], $sql);

        return '<div><code>'.nl2br(trim(vsprintf($sql, $bindings))).'</code></div>';
    }

    /**
     * Perform query analysis hint.
     */
    public static function performQueryAnalysis(string $sql, ?float $version = null, ?string $driver = null): array
    {
        $hints = [];
        if (preg_match('/^\\s*SELECT\\s*`?[a-zA-Z0-9]*`?\\.?\\*/i', $sql)) {
            $hints[] = 'Use <code>SELECT *</code> only if you need all columns from table';
        }

        if (preg_match('/ORDER BY RAND()/i', $sql)) {
            $hints[] = '<code>ORDER BY RAND()</code> is slow, try to avoid if you can.
                You can <a href="http://stackoverflow.com/questions/2663710/how-does-mysqls-order-by-rand-work">read this</a>
                or <a href="http://stackoverflow.com/questions/1244555/how-can-i-optimize-mysqls-order-by-rand-function">this</a>';
        }

        if (false !== strpos($sql, '!=')) {
            $hints[] = 'The <code>!=</code> operator is not standard. Use the <code>&lt;&gt;</code> operator to test for inequality instead.';
        }

        if (false === stripos($sql, 'WHERE')) {
            $hints[] = 'The <code>SELECT</code> statement has no <code>WHERE</code> clause and could examine many more rows than intended';
        }

        if (preg_match('/LIMIT\\s/i', $sql) && false === stripos($sql, 'ORDER BY')) {
            $hints[] = '<code>LIMIT</code> without <code>ORDER BY</code> causes non-deterministic results, depending on the query execution plan';
        }

        if (preg_match('/LIKE\\s[\'"](%.*?)[\'"]/i', $sql, $matches)) {
            $hints[] = 'An argument has a leading wildcard character: <code>'.$matches[1].'</code>.
                The predicate with this argument is not sargable and cannot use an index if one exists.';
        }

        if ($version < 5.5 && 'mysql' === $driver && preg_match('/\\sIN\\s*\\(\\s*SELECT/i', $sql)) {
            $hints[] = '<code>IN()</code> and <code>NOT IN()</code> subqueries are poorly optimized in that MySQL version : '.$version.
                       '. MySQL executes the subquery as a dependent subquery for each row in the outer query';
        }

        return $hints;
    }

    /**
     * Explain sql.
     */
    public static function explain(\PDO $pdo, string $sql, array $bindings = []): array
    {
        $explains = [];
        if (preg_match('#\s*\(?\s*SELECT\s#iA', $sql)) {
            $statement = $pdo->prepare('EXPLAIN '.$sql);
            $statement->execute($bindings);
            $explains = $statement->fetchAll(\PDO::FETCH_CLASS);
        }

        return $explains;
    }
}

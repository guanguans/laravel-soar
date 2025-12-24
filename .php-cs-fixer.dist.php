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

use AdamWojs\PhpCsFixerPhpdocForceFQCN\Fixer\Phpdoc\ForceFQCNFixer;
use Ergebnis\License\Holder;
use Ergebnis\License\Range;
use Ergebnis\License\Type\MIT;
use Ergebnis\License\Url;
use Ergebnis\License\Year;
use Ergebnis\PhpCsFixer\Config\Factory;
use Ergebnis\PhpCsFixer\Config\Fixers;
use Ergebnis\PhpCsFixer\Config\Rules;
use Ergebnis\PhpCsFixer\Config\RuleSet\Php81;
use PhpCsFixer\Finder;
use PhpCsFixer\Fixer\DeprecatedFixerInterface;
use PhpCsFixer\Fixer\FixerInterface;

require __DIR__.'/vendor/autoload.php';

// putenv('PHP_CS_FIXER_ENFORCE_CACHE=1');
// putenv('PHP_CS_FIXER_IGNORE_ENV=1');
putenv('PHP_CS_FIXER_FUTURE_MODE=1');
putenv('PHP_CS_FIXER_NON_MONOLITHIC=1');
putenv('PHP_CS_FIXER_PARALLEL=1');

return Factory::fromRuleSet(Php81::create()
    ->withHeader(
        (static function (): string {
            $mit = MIT::text(
                __DIR__.'/LICENSE',
                Range::since(
                    Year::fromString('2020'),
                    new DateTimeZone('Asia/Shanghai'),
                ),
                Holder::fromString('guanguans<ityaozm@gmail.com>'),
                Url::fromString('https://github.com/guanguans/laravel-soar'),
            );

            $mit->save();

            return $mit->header();
        })()
    )
    ->withCustomFixers(Fixers::fromFixers($forceFQCNFixer = new ForceFQCNFixer))
    ->withCustomFixers(Fixers::fromFixers(...$erickSkrauchFixers = array_filter(
        iterator_to_array(new ErickSkrauch\PhpCsFixer\Fixers),
        static fn (FixerInterface $fixer): bool => !$fixer instanceof DeprecatedFixerInterface
            && !\array_key_exists($fixer->getName(), Php81::create()->rules()->toArray())
            && !\in_array(
                $fixer->getName(),
                [
                    'ErickSkrauch/align_multiline_parameters',
                    'ErickSkrauch/blank_line_around_class_body',
                ],
                true
            )
    )))
    ->withRules(Rules::fromArray(array_reduce(
        $erickSkrauchFixers,
        static function (array $carry, FixerInterface $fixer): array {
            $carry[$fixer->getName()] = true;

            return $carry;
        },
        []
    )))
    ->withCustomFixers(Fixers::fromFixers(...$phpCsFixerCustomFixers = array_filter(
        iterator_to_array(new PhpCsFixerCustomFixers\Fixers),
        static fn (FixerInterface $fixer): bool => !$fixer instanceof DeprecatedFixerInterface
            && !\array_key_exists($fixer->getName(), Php81::create()->rules()->toArray())
            && !\in_array(
                $fixer->getName(),
                [
                    'PhpCsFixerCustomFixers/comment_surrounded_by_spaces',
                    'PhpCsFixerCustomFixers/declare_after_opening_tag',
                    'PhpCsFixerCustomFixers/isset_to_array_key_exists',
                    'PhpCsFixerCustomFixers/no_commented_out_code',
                    // 'PhpCsFixerCustomFixers/no_leading_slash_in_global_namespace',
                    'PhpCsFixerCustomFixers/no_nullable_boolean_type',
                    'PhpCsFixerCustomFixers/phpdoc_only_allowed_annotations',
                    'PhpCsFixerCustomFixers/typed_class_constant', // @since 8.3
                ],
                true
            )
    )))
    ->withRules(Rules::fromArray(array_reduce(
        $phpCsFixerCustomFixers,
        static function (array $carry, FixerInterface $fixer): array {
            $carry[$fixer->getName()] = true;

            return $carry;
        },
        []
    )))
    ->withRules(Rules::fromArray([
        // '@auto' => true,
        // '@auto:risky' => true,
        // '@autoPHPMigration' => true,
        // '@autoPHPMigration:risky' => true,
        // '@autoPHPUnitMigration:risky' => true,
        // '@DoctrineAnnotation' => true,
        // '@PHP7x4Migration' => true,
        // '@PHP7x4Migration:risky' => true,
        // '@PHP8x0Migration' => true,
        // '@PHP8x0Migration:risky' => true,
        '@PHP8x1Migration' => true,
        // '@PHP8x1Migration:risky' => true,
        // '@PHP8x2Migration' => true,
        // '@PHP8x2Migration:risky' => true,
        // '@PHP8x3Migration' => true,
        // '@PHP8x3Migration:risky' => true,
        // '@PHP8x4Migration' => true,
        // '@PHP8x4Migration:risky' => true,
        // '@PHP8x5Migration' => true,
        // '@PHP8x5Migration:risky' => true,
        // '@PhpCsFixer' => true,
        // '@PhpCsFixer:risky' => true,
        // '@PHPUnit8x4Migration:risky' => true,
        // '@PHPUnit9x1Migration:risky' => true,
        '@PHPUnit10x0Migration:risky' => true,
    ]))
    ->withRules(Rules::fromArray([
        $forceFQCNFixer->getName() => true,
        'align_multiline_comment' => [
            'comment_type' => 'phpdocs_only',
        ],
        'attribute_empty_parentheses' => [
            'use_parentheses' => false,
        ],
        'blank_line_before_statement' => [
            'statements' => [
                'break',
                // 'case',
                'continue',
                'declare',
                // 'default',
                'do',
                'exit',
                'for',
                'foreach',
                'goto',
                'if',
                'include',
                'include_once',
                'phpdoc',
                'require',
                'require_once',
                'return',
                'switch',
                'throw',
                'try',
                'while',
                'yield',
                'yield_from',
            ],
        ],
        'class_definition' => [
            'inline_constructor_arguments' => false,
            'multi_line_extends_each_single_line' => false,
            'single_item_single_line' => false,
            'single_line' => false,
            'space_before_parenthesis' => false,
        ],
        'concat_space' => [
            'spacing' => 'none',
        ],
        'empty_loop_condition' => [
            'style' => 'for',
        ],
        'explicit_string_variable' => false,
        'final_class' => false,
        // 'final_internal_class' => false,
        'final_public_method_for_abstract_class' => false,
        'fully_qualified_strict_types' => [
            'import_symbols' => false,
            'leading_backslash_in_global_namespace' => false,
            'phpdoc_tags' => [
                // 'param',
                // 'phpstan-param',
                // 'phpstan-property',
                // 'phpstan-property-read',
                // 'phpstan-property-write',
                // 'phpstan-return',
                // 'phpstan-var',
                // 'property',
                // 'property-read',
                // 'property-write',
                // 'psalm-param',
                // 'psalm-property',
                // 'psalm-property-read',
                // 'psalm-property-write',
                // 'psalm-return',
                // 'psalm-var',
                // 'return',
                // 'see',
                // 'throws',
                // 'var',
            ],
        ],
        'logical_operators' => false,
        'mb_str_functions' => false,
        'native_function_invocation' => [
            'exclude' => [],
            'include' => ['@compiler_optimized', 'is_scalar'],
            'scope' => 'all',
            'strict' => true,
        ],
        'new_with_parentheses' => [
            'anonymous_class' => false,
            'named_class' => false,
        ],
        'no_extra_blank_lines' => [
            'tokens' => [
                'attribute',
                'break',
                'case',
                // 'comma',
                'continue',
                'curly_brace_block',
                'default',
                'extra',
                'parenthesis_brace_block',
                'return',
                'square_brace_block',
                'switch',
                'throw',
                'use',
            ],
        ],
        'ordered_traits' => [
            'case_sensitive' => true,
        ],
        'php_unit_data_provider_name' => [
            'prefix' => 'provide',
            'suffix' => 'Cases',
        ],
        'phpdoc_align' => [
            'align' => 'left',
            'spacing' => 1,
            'tags' => [
                'method',
                'param',
                'property',
                'property-read',
                'property-write',
                'return',
                'throws',
                'type',
                'var',
            ],
        ],
        'phpdoc_line_span' => [
            'const' => 'single',
            'method' => 'multi',
            'property' => 'single',
        ],
        'phpdoc_no_alias_tag' => [
            'replacements' => [
                'link' => 'see',
                // 'property-read' => 'property',
                // 'property-write' => 'property',
                'type' => 'var',
            ],
        ],
        'phpdoc_order' => [
            'order' => [
                'noinspection',
                'phan-suppress',
                'phpcsSuppress',
                'phpstan-ignore',
                'psalm-suppress',

                'deprecated',
                'internal',
                'covers',
                'uses',
                'dataProvider',
                'param',
                'throws',
                'return',
            ],
        ],
        'phpdoc_order_by_value' => [
            'annotations' => [
                'author',
                'covers',
                'coversNothing',
                'dataProvider',
                'depends',
                'group',
                'internal',
                // 'method',
                'mixin',
                'property',
                'property-read',
                'property-write',
                'requires',
                'throws',
                'uses',
            ],
        ],
        'phpdoc_to_param_type' => [
            'scalar_types' => true,
            'types_map' => [],
            'union_types' => true,
        ],
        'phpdoc_to_property_type' => [
            'scalar_types' => true,
            'types_map' => [],
            'union_types' => true,
        ],
        'phpdoc_to_return_type' => [
            'scalar_types' => true,
            'types_map' => [],
            'union_types' => true,
        ],
        'simplified_if_return' => true,
        'simplified_null_return' => true,
        'single_line_empty_body' => true,
        'statement_indentation' => [
            'stick_comment_to_next_continuous_control_statement' => true,
        ],
        'static_lambda' => false, // pest
        'static_private_method' => false,
    ])))
    ->setUsingCache(true)
    ->setCacheFile(\sprintf('%s/.build/php-cs-fixer/%s.cache', __DIR__, pathinfo(__FILE__, \PATHINFO_FILENAME)))
    ->setUnsupportedPhpVersionAllowed(true)
    ->setFinder(
        /**
         * @see https://github.com/laravel/pint/blob/main/app/Commands/DefaultCommand.php
         * @see https://github.com/laravel/pint/blob/main/app/Factories/ConfigurationFactory.php
         * @see https://github.com/laravel/pint/blob/main/app/Repositories/ConfigurationJsonRepository.php
         */
        Finder::create()
            ->in(__DIR__)
            ->exclude([
                'Fixtures/',
                'vendor-bin/',
            ])
            ->notPath([
                // '/lang\/.*\.json$/',
            ])
            ->notName([
                '/\.blade\.php$/',
            ])
            ->ignoreDotFiles(false)
            ->ignoreUnreadableDirs(false)
            ->ignoreVCS(true)
            ->ignoreVCSIgnored(true)
            ->append([
                __DIR__.'/composer-bump',
                __DIR__.'/rule-doc-generator',
            ])
    );

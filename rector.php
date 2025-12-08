<?php

/** @noinspection PhpUnusedAliasInspection */
/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2020-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-soar
 */

use Carbon\Carbon;
use Ergebnis\Rector\Rules\Arrays\SortAssociativeArrayByKeyRector;
use Guanguans\LaravelSoar\Contracts\ThrowableContract;
use Guanguans\MonorepoBuilderWorker\Support\Rectors\AddNoinspectionsDocCommentToDeclareRector;
use Guanguans\MonorepoBuilderWorker\Support\Rectors\NewExceptionToNewAnonymousExtendsExceptionImplementsRector;
use Guanguans\MonorepoBuilderWorker\Support\Rectors\RemoveNamespaceRector;
use Guanguans\MonorepoBuilderWorker\Support\Rectors\SimplifyListIndexRector;
use Illuminate\Support\Carbon as IlluminateCarbon;
use Illuminate\Support\Str;
use Rector\CodeQuality\Rector\If_\ExplicitBoolCompareRector;
use Rector\CodeQuality\Rector\LogicalAnd\LogicalToBooleanRector;
use Rector\CodingStyle\Rector\ArrowFunction\StaticArrowFunctionRector;
use Rector\CodingStyle\Rector\ClassLike\NewlineBetweenClassLikeStmtsRector;
use Rector\CodingStyle\Rector\Closure\StaticClosureRector;
use Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector;
use Rector\CodingStyle\Rector\Encapsed\WrapEncapsedVariableInCurlyBracesRector;
use Rector\CodingStyle\Rector\FuncCall\ArraySpreadInsteadOfArrayMergeRector;
use Rector\CodingStyle\Rector\Stmt\NewlineAfterStatementRector;
use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\ClassLike\RemoveAnnotationRector;
use Rector\EarlyReturn\Rector\If_\ChangeOrIfContinueToMultiContinueRector;
use Rector\EarlyReturn\Rector\Return_\ReturnBinaryOrToEarlyReturnRector;
use Rector\Php71\Rector\FuncCall\RemoveExtraParametersRector;
use Rector\Php73\Rector\FuncCall\JsonThrowOnErrorRector;
use Rector\Php80\Rector\Class_\AnnotationToAttributeRector;
use Rector\Php80\ValueObject\AnnotationToAttribute;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\Renaming\Rector\FuncCall\RenameFunctionRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Transform\Rector\FuncCall\FuncCallToStaticCallRector;
use Rector\Transform\Rector\StaticCall\StaticCallToFuncCallRector;
use Rector\Transform\ValueObject\FuncCallToStaticCall;
use Rector\Transform\ValueObject\StaticCallToFuncCall;
use Rector\ValueObject\PhpVersion;
use Rector\ValueObject\Visibility;
use Rector\Visibility\Rector\ClassMethod\ChangeMethodVisibilityRector;
use Rector\Visibility\ValueObject\ChangeMethodVisibility;
use RectorLaravel\Rector\ArrayDimFetch\ArrayToArrGetRector;
use RectorLaravel\Rector\Class_\ModelCastsPropertyToCastsMethodRector;
use RectorLaravel\Rector\Empty_\EmptyToBlankAndFilledFuncRector;
use RectorLaravel\Rector\FuncCall\HelperFuncCallToFacadeClassRector;
use RectorLaravel\Rector\FuncCall\RemoveDumpDataDeadCodeRector;
use RectorLaravel\Rector\FuncCall\TypeHintTappableCallRector;
use RectorLaravel\Rector\If_\ThrowIfRector;
use RectorLaravel\Rector\StaticCall\DispatchToHelperFunctionsRector;
use RectorLaravel\Set\LaravelSetList;
use RectorLaravel\Set\LaravelSetProvider;
use function Guanguans\LaravelSoar\Support\classes;

return RectorConfig::configure()
    ->withPaths([
        // __DIR__.'/config/',
        __DIR__.'/src/',
        __DIR__.'/tests/',
        __DIR__.'/workbench/',
        __DIR__.'/composer-bump',
    ])
    ->withRootFiles()
    ->withAutoloadPaths([
        // (new ReflectionClass(Throwable::class))->getFileName(),
    ])
    ->withBootstrapFiles([
        // __DIR__.'/vendor/symplify/monorepo-builder/vendor/autoload.php',
        // __DIR__.'/vendor/symplify/monorepo-builder/vendor/scoper-autoload.php',
    ])
    ->withSkip([
        '**/Fixtures/*',
        __DIR__.'/tests.php',
        __FILE__,
    ])
    ->withCache(__DIR__.'/.build/rector/')
    // ->withoutParallel()
    ->withParallel()
    ->withImportNames(importDocBlockNames: false, importShortClasses: false)
    // ->withImportNames(importNames: false)
    // ->withEditorUrl()
    ->withFluentCallNewLine()
    ->withTreatClassesAsFinal()
    ->withAttributesSets(phpunit: true, all: true)
    ->withComposerBased(phpunit: true, laravel: true)
    ->withSetProviders(LaravelSetProvider::class)
    ->withPhpVersion(PhpVersion::PHP_81)
    ->withDowngradeSets(php81: true)
    ->withPhpSets(php81: true)
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        codingStyle: true,
        typeDeclarations: true,
        typeDeclarationDocblocks: true,
        privatization: true,
        naming: true,
        instanceOf: true,
        earlyReturn: true,
        carbon: true,
    )
    ->withSets([
        PHPUnitSetList::PHPUNIT_100,
        ...collect((new ReflectionClass(LaravelSetList::class))->getConstants(ReflectionClassConstant::IS_PUBLIC))
            ->reject(
                static fn (string $constant, string $name): bool => \in_array(
                    $name,
                    ['LARAVEL_STATIC_TO_INJECTION', 'LUMEN'],
                    true
                ) || preg_match('/^LARAVEL_\d{2,3}$/', $name)
            )
            // ->dd()
            ->all(),
    ])
    ->withRules([
        ArraySpreadInsteadOfArrayMergeRector::class,
        JsonThrowOnErrorRector::class,
        SimplifyListIndexRector::class,
        SortAssociativeArrayByKeyRector::class,
        StaticArrowFunctionRector::class,
        StaticClosureRector::class,
        ...classes(static fn (string $class): bool => str_starts_with($class, 'RectorLaravel\Rector'))
            ->filter(static fn (ReflectionClass $reflectionClass): bool => $reflectionClass->isInstantiable())
            ->keys()
            // ->dd()
            ->all(),
    ])
    ->withConfiguredRule(AddNoinspectionsDocCommentToDeclareRector::class, [
        'AnonymousFunctionStaticInspection',
        'NullPointerExceptionInspection',
        'PhpPossiblePolymorphicInvocationInspection',
        'PhpUndefinedClassInspection',
        'PhpUnhandledExceptionInspection',
        'PhpVoidFunctionResultUsedInspection',
        'SqlResolve',
        'StaticClosureCanBeUsedInspection',
    ])
    ->withConfiguredRule(NewExceptionToNewAnonymousExtendsExceptionImplementsRector::class, [
        ThrowableContract::class,
    ])
    ->withConfiguredRule(RemoveNamespaceRector::class, [
        'Guanguans\LaravelSoarTests',
    ])
    ->withConfiguredRule(RemoveAnnotationRector::class, [
        'codeCoverageIgnore',
        'inheritDoc',
        'phpstan-ignore',
        'phpstan-ignore-next-line',
        'psalm-suppress',
    ])
    ->withConfiguredRule(RenameClassRector::class, [
        Carbon::class => IlluminateCarbon::class,
    ])
    ->withConfiguredRule(FuncCallToStaticCallRector::class, [
        // new FuncCallToStaticCall('str', Str::class, 'of'),
    ])
    ->withConfiguredRule(StaticCallToFuncCallRector::class, [
        new StaticCallToFuncCall(Str::class, 'of', 'str'),
    ])
    ->withConfiguredRule(
        AnnotationToAttributeRector::class,
        classes(static fn (string $class): bool => str_starts_with($class, 'PhpBench\Attributes'))
            ->filter(static fn (ReflectionClass $reflectionClass): bool => $reflectionClass->isInstantiable())
            ->map(static fn (ReflectionClass $reflectionClass): AnnotationToAttribute => new AnnotationToAttribute(
                $reflectionClass->getShortName(),
                $reflectionClass->getName(),
                [],
                true
            ))
            ->all(),
    )
    ->withConfiguredRule(
        ChangeMethodVisibilityRector::class,
        classes(static fn (string $class, string $file): bool => str_starts_with($class, 'Guanguans\LaravelSoar'))
            ->filter(static fn (ReflectionClass $reflectionClass): bool => $reflectionClass->isTrait())
            ->map(
                static fn (ReflectionClass $reflectionClass): array => collect($reflectionClass->getMethods(ReflectionMethod::IS_PRIVATE))
                    ->reject(static fn (ReflectionMethod $reflectionMethod): bool => $reflectionMethod->isFinal() || $reflectionMethod->isInternal())
                    ->map(static fn (ReflectionMethod $reflectionMethod): ChangeMethodVisibility => new ChangeMethodVisibility(
                        $reflectionClass->getName(),
                        $reflectionMethod->getName(),
                        Visibility::PROTECTED
                    ))
                    ->all()
            )
            ->flatten()
            // ->dd()
            ->all(),
    )
    ->withConfiguredRule(
        RenameFunctionRector::class,
        [
            // 'app' => 'resolve',
            'Pest\Faker\fake' => 'fake',
            'Pest\Faker\faker' => 'fake',
            'test' => 'it',
        ] + array_reduce(
            [
                'classes',
                'env_explode',
                'human_milliseconds',
                'json_pretty_encode',
            ],
            static function (array $carry, string $func): array {
                /** @see https://github.com/laravel/framework/blob/11.x/src/Illuminate/Support/functions.php */
                $carry[$func] = "Guanguans\\LaravelSoar\\Support\\$func";

                return $carry;
            },
            []
        )
    )
    ->withSkip([
        ChangeOrIfContinueToMultiContinueRector::class,
        EncapsedStringsToSprintfRector::class,
        ExplicitBoolCompareRector::class,
        LogicalToBooleanRector::class,
        NewlineAfterStatementRector::class,
        NewlineBetweenClassLikeStmtsRector::class,
        ReturnBinaryOrToEarlyReturnRector::class,
        WrapEncapsedVariableInCurlyBracesRector::class,
    ])
    ->withSkip([
        ModelCastsPropertyToCastsMethodRector::class,
        TypeHintTappableCallRector::class,

        ArrayToArrGetRector::class,
        DispatchToHelperFunctionsRector::class,
        EmptyToBlankAndFilledFuncRector::class,
        HelperFuncCallToFacadeClassRector::class,
        ThrowIfRector::class,
    ])
    ->withSkip([
        RemoveDumpDataDeadCodeRector::class => [
            __DIR__.'/src/Mixins/QueryBuilderMixin.php',
        ],
        RemoveExtraParametersRector::class => [
            __DIR__.'/src/Mixins/',
        ],
        StaticArrowFunctionRector::class => $staticClosureSkipPaths = [
            __DIR__.'/tests/',
        ],
        StaticClosureRector::class => $staticClosureSkipPaths,
        SortAssociativeArrayByKeyRector::class => [
            // __DIR__.'/config/',
            __DIR__.'/src/',
            __DIR__.'/tests/',
            __DIR__.'/workbench/',
        ],
        AddNoinspectionsDocCommentToDeclareRector::class => [
            // __DIR__.'/config/',
            __DIR__.'/src/',
            // __DIR__.'/tests/',
            __DIR__.'/workbench/',
            ...$rootFiles = array_filter(
                glob(__DIR__.'/{*,.*}.php', \GLOB_BRACE),
                static fn (string $filename): bool => !\in_array(
                    $filename,
                    [
                        __DIR__.'/tests.php',
                        __DIR__.'/tests.php',
                    ],
                    true
                )
            ),
            __DIR__.'/composer-bump',
        ],
        NewExceptionToNewAnonymousExtendsExceptionImplementsRector::class => [
            __DIR__.'/src/Support/Rectors/',
        ],
        RemoveNamespaceRector::class => [
            // __DIR__.'/config/',
            __DIR__.'/src/',
            // __DIR__.'/tests/',
            __DIR__.'/workbench/',
            ...$rootFiles,
            __DIR__.'/composer-bump',
            __DIR__.'/tests/TestCase.php',
        ],
    ]);

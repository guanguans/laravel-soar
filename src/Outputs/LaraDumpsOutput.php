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

namespace Guanguans\LaravelSoar\Outputs;

use Illuminate\Console\Events\CommandFinished;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

class LaraDumpsOutput extends AbstractOutput
{
    public function __construct(private string $label = 'Soar Scores') {}

    /**
     * @noinspection PhpMissingParentCallCommonInspection
     */
    public function shouldOutput(CommandFinished|Response $outputter): bool
    {
        return \function_exists('ds');
    }

    public function output(Collection $scores, CommandFinished|Response $outputter): mixed
    {
        return ds(...$scores)->label($this->label);
    }
}

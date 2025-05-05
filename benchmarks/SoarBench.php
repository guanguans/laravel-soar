<?php

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Guanguans\SoarPHP\Soar;

/**
 * @beforeMethods({"setUp"})
 *
 * @warmup(2)
 *
 * @revs(10)
 *
 * @iterations(3)
 */
final class SoarBench
{
    /**
     * @var Soar
     */
    private $soar;

    public function setUp(): void
    {
        $this->soar = Soar::create();
    }

    public function benchScore(): void
    {
        $this->soar->score('select * from user;');
    }

    public function benchSyntaxCheck(): void
    {
        $this->soar->syntaxCheck('select * from user id = 1;');
    }

    public function benchPretty(): void
    {
        $this->soar->pretty('select * from user;');
    }

    public function benchMd2html(): void
    {
        $this->soar->md2html('## This is a testing.');
    }

    public function benchFingerPrint(): void
    {
        $this->soar->fingerPrint('select * from user where id = 1;');
    }

    public function benchHelp(): void
    {
        $this->soar->help();
    }
}

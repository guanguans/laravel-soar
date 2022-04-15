<?php

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelSoar\Http\Controllers;

use DateTime;
use Guanguans\LaravelSoar\SoarDebugBar;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

/**
 * This is modified from the https://github.com/barryvdh/laravel-debugbar.
 *
 * @see https://github.com/barryvdh/laravel-debugbar/blob/master/src/Controllers/AssetController.php
 */
class AssetController extends Controller
{
    public function __construct(SoarDebugBar $debugBar)
    {
        $this->debugBar = $debugBar;
    }

    /**
     * Return the javascript for the DebugBar.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function js()
    {
        $renderer = $this->debugBar->getJavascriptRenderer();
        $content = $renderer->dumpAssetsToString('js');
        $response = new Response(
            $content,
            200,
            ['Content-Type' => 'text/javascript']
        );

        return $this->cacheResponse($response);
    }

    /**
     * Return the stylesheets for the DebugBar.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function css()
    {
        $renderer = $this->debugBar->getJavascriptRenderer();
        $content = $renderer->dumpAssetsToString('css');
        $response = new Response(
            $content,
            200,
            ['Content-Type' => 'text/css']
        );

        return $this->cacheResponse($response);
    }

    /**
     * Cache the response 1 year (31536000 sec).
     */
    protected function cacheResponse(Response $response)
    {
        $response->setSharedMaxAge(31536000);
        $response->setMaxAge(31536000);
        $response->setExpires(new DateTime('+1 year'));

        return $response;
    }
}

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
use Guanguans\LaravelSoar\SoarBar;
use Illuminate\Http\Response;

/**
 * This is modified from the https://github.com/barryvdh/laravel-debugbar.
 *
 * @see https://github.com/barryvdh/laravel-debugbar/blob/master/src/Controllers/AssetController.php
 */
class AssetController
{
    /**
     * @var \DebugBar\JavascriptRenderer
     */
    private $renderer;

    public function __construct(SoarBar $debugBar)
    {
        $this->renderer = $debugBar->getJavascriptRenderer();
    }

    /**
     * Return the javascript for the DebugBar.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function js()
    {
        $js = $this->renderer->dumpAssetsToString('js');
        $response = new Response($js, 200, ['Content-Type' => 'text/javascript']);

        return $this->cacheResponse($response);
    }

    /**
     * Return the stylesheets for the DebugBar.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function css()
    {
        $css = $this->renderer->dumpAssetsToString('css');
        $response = new Response($css, 200, ['Content-Type' => 'text/css']);

        return $this->cacheResponse($response);
    }

    public function fonts(string $suffix)
    {
        $file = base_path("vendor/maximebf/debugbar/src/DebugBar/Resources/vendor/font-awesome/fonts/fontawesome-webfont.$suffix");
        $response = new Response(file_get_contents($file), 200, ['Content-Type' => 'text/font']);

        return $this->cacheResponse($response);
    }

    public function fontAwesome()
    {
        $file = base_path('vendor/maximebf/debugbar/src/DebugBar/Resources/vendor/font-awesome/fonts/FontAwesome.otf');
        $response = new Response(file_get_contents($file), 200, ['Content-Type' => 'text/font']);

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

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

namespace Guanguans\LaravelSoar\Http\Controllers;

use Guanguans\LaravelSoar\JavascriptRenderer;
use Guanguans\LaravelSoar\SoarBar;
use Illuminate\Http\Response;

/**
 * This is modified from the https://github.com/barryvdh/laravel-debugbar.
 *
 * @see https://github.com/barryvdh/laravel-debugbar/blob/master/src/Controllers/AssetController.php
 */
class AssetController
{
    private JavascriptRenderer $javascriptRenderer;

    /**
     * @noinspection PhpFieldAssignmentTypeMismatchInspection
     */
    public function __construct(SoarBar $soarBar)
    {
        $this->javascriptRenderer = $soarBar->getJavascriptRenderer();
    }

    /**
     * Return the javascript for the DebugBar.
     */
    public function js(): Response
    {
        $js = $this->javascriptRenderer->dumpAssetsToString('js');
        $response = new Response($js, 200, ['Content-Type' => 'text/javascript']);

        return $this->cacheResponse($response);
    }

    /**
     * Return the stylesheets for the DebugBar.
     */
    public function css(): Response
    {
        $css = $this->javascriptRenderer->dumpAssetsToString('css');
        $response = new Response($css, 200, ['Content-Type' => 'text/css']);

        return $this->cacheResponse($response);
    }

    /**
     * Return the font for the DebugBar.
     *
     * @codeCoverageIgnore
     */
    public function font(string $suffix): Response
    {
        // $file = __DIR__."/../../../vendor/maximebf/debugbar/src/DebugBar/Resources/vendor/font-awesome/fonts/fontawesome-webfont.$suffix";
        $file = base_path("vendor/maximebf/debugbar/src/DebugBar/Resources/vendor/font-awesome/fonts/fontawesome-webfont.$suffix");
        $response = new Response(file_get_contents($file), 200, ['Content-Type' => 'text/font']);

        return $this->cacheResponse($response);
    }

    /**
     * Return the FontAwesome.otf for the DebugBar.
     *
     * @codeCoverageIgnore
     */
    public function fontAwesome(): Response
    {
        // $file = __DIR__.'/../../../vendor/maximebf/debugbar/src/DebugBar/Resources/vendor/font-awesome/fonts/FontAwesome.otf';
        $file = base_path('vendor/maximebf/debugbar/src/DebugBar/Resources/vendor/font-awesome/fonts/FontAwesome.otf');
        $response = new Response(file_get_contents($file), 200, ['Content-Type' => 'text/font']);

        return $this->cacheResponse($response);
    }

    /**
     * Cache the response 1 year (31536000 sec).
     */
    protected function cacheResponse(Response $response): Response
    {
        $response->setSharedMaxAge(31_536_000);
        $response->setMaxAge(31_536_000);
        $response->setExpires(new \DateTimeImmutable('+1 year'));

        return $response;
    }
}

<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-soar.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelSoar;

/**
 * This is modified from the https://github.com/barryvdh/laravel-debugbar.
 *
 * @internal
 *
 * @see https://github.com/barryvdh/laravel-debugbar/blob/master/src/JavascriptRenderer.php
 */
class JavascriptRenderer extends \DebugBar\JavascriptRenderer
{
    /**
     * Use XHR handler by default, instead of jQuery
     */
    protected $ajaxHandlerBindToJquery = false;

    protected $ajaxHandlerBindToXHR = true;

    /**
     * @noinspection MissingParentCallInspection
     */
    public function renderHead(): string
    {
        $cssRoute = preg_replace(
            '/\Ahttps?:/',
            '',
            route(config('soar.route.as', 'soar.bar.').'assets.css', ['v' => $this->getModifiedTime('css')])
        );
        $jsRoute = preg_replace(
            '/\Ahttps?:/',
            '',
            route(config('soar.route.as', 'soar.bar.').'assets.js', ['v' => $this->getModifiedTime('js')])
        );
        $base64Logo = base64_encode_file(__DIR__.'/../art/logo.svg');

        $html =
            // @lang HTML
            <<<HTML
                <link rel="stylesheet" type="text/css" property="stylesheet" href="$cssRoute">
                <style>
                    div.phpdebugbar-header, a.phpdebugbar-restore-btn {
                        background: #efefef url(data:image/svg+xml;base64,$base64Logo)  no-repeat 5px 4px / 20px 20px;
                    }

                    div.phpdebugbar-widgets-messages div.phpdebugbar-widgets-toolbar {
                        width: calc(100% - 20px);
                        padding: 4px 0px 4px;
                        height: 20px;
                        border: 1px solid #ddd;
                        border-bottom: 0px;
                        background-color: #e8e8e8;
                        border-radius: 5px 5px 0px 0px;
                    }

                    div.phpdebugbar-widgets-messages div.phpdebugbar-widgets-toolbar input {
                        width: calc(100% - 48px);
                        margin-left: 0px;
                        border-radius: 3px;
                        padding: 2px 6px;
                        height: 15px;
                    }

                    .phpdebugbar-widgets-toolbar i.phpdebugbar-fa.phpdebugbar-fa-search {
                        position: relative;
                        top: -1px;
                        padding: 0px 10px;
                    }

                    div.phpdebugbar-widgets-messages div.phpdebugbar-widgets-toolbar a.phpdebugbar-widgets-filter,
                    div.phpdebugbar-widgets-messages div.phpdebugbar-widgets-toolbar a.phpdebugbar-widgets-filter.phpdebugbar-widgets-excluded {
                        position: relative;
                        top: -48px;
                        display: inline-block;
                        background-color: #6d6d6d;
                        margin-left: 3px;
                        border-radius: 3px;
                        padding: 5px 8px 4px;
                        text-transform: uppercase;
                        font-size: 10px;
                        text-shadow: 1px 1px #585858;
                        transition: background-color .25s linear 0s, color .25s linear 0s;
                        color: #FFF;

                        -webkit-touch-callout: none;
                        -webkit-user-select: none;
                        -khtml-user-select: none;
                        -moz-user-select: none;
                        -ms-user-select: none;
                        user-select: none;
                    }

                    div.phpdebugbar-widgets-messages div.phpdebugbar-widgets-toolbar a.phpdebugbar-widgets-filter[rel="info"],
                    div.phpdebugbar-widgets-messages div.phpdebugbar-widgets-toolbar a.phpdebugbar-widgets-filter.phpdebugbar-widgets-excluded[rel="info"] {
                        background-color: #5896e2;
                    }

                    div.phpdebugbar-widgets-messages div.phpdebugbar-widgets-toolbar a.phpdebugbar-widgets-filter[rel="error"],
                    div.phpdebugbar-widgets-messages div.phpdebugbar-widgets-toolbar a.phpdebugbar-widgets-filter.phpdebugbar-widgets-excluded[rel="error"] {
                        background-color: #fa5661;
                    }

                    div.phpdebugbar-widgets-messages div.phpdebugbar-widgets-toolbar a.phpdebugbar-widgets-filter[rel="warning"],
                    div.phpdebugbar-widgets-messages div.phpdebugbar-widgets-toolbar a.phpdebugbar-widgets-filter.phpdebugbar-widgets-excluded[rel="warning"] {
                        background-color: #f99400;
                    }

                    div.phpdebugbar-widgets-messages div.phpdebugbar-widgets-toolbar a.phpdebugbar-widgets-filter:hover {
                        color: #FFF;
                        opacity: 0.85;
                    }

                    div.phpdebugbar-widgets-messages div.phpdebugbar-widgets-toolbar a.phpdebugbar-widgets-filter.phpdebugbar-widgets-excluded {
                        opacity: 0.45;
                    }

                    .phpdebugbar-widgets-toolbar > .fa {
                        width: 25px;
                        font-size: 15px;
                        color: #555;
                        text-align: center;
                    }
                </style>
                <script src="$jsRoute"></script>
                HTML;

        if ($this->isJqueryNoConflictEnabled()) {
            $html .= "<script>jQuery.noConflict(true);</script>\n";
        }

        return $html.$this->getInlineHtml();
    }

    /**
     * Return assets as a string.
     *
     * @param string $type 'js' or 'css'
     */
    public function dumpAssetsToString(string $type): string
    {
        return array_reduce(
            $this->getAssets($type),
            static fn (string $contents, string $file): string => $contents .= file_get_contents($file).PHP_EOL,
            ''
        );
    }

    /**
     * Get inline HTML.
     */
    protected function getInlineHtml(): string
    {
        $html = '';
        foreach (['head', 'css', 'js'] as $asset) {
            foreach ($this->getAssets('inline_'.$asset) as $item) {
                $html .= $item.PHP_EOL;
            }
        }

        return $html;
    }

    /**
     * Get the last modified time of any assets.
     *
     * @param null|string $type 'js' or 'css'
     */
    protected function getModifiedTime(?string $type): int
    {
        $files = $this->getAssets($type);

        $latest = 0;
        foreach ($files as $file) {
            $mtime = filemtime($file);
            if ($mtime > $latest) {
                $latest = $mtime;
            }
        }

        return $latest;
    }

    /**
     * {@inheritDoc}
     *
     * @noinspection MissingParentCallInspection
     */
    protected function makeUriRelativeTo($uri, $root)
    {
        if (! $root) {
            return $uri;
        }

        if (\is_array($uri)) {
            $uris = [];
            foreach ($uri as $u) {
                $uris[] = $this->makeUriRelativeTo($u, $root);
            }

            return $uris;
        }

        if ('/' === substr($uri ?? '', 0, 1) || preg_match('/^([a-zA-Z]+:\/\/|[a-zA-Z]:\/|[a-zA-Z]:\\\)/', $uri ?? '')) {
            return $uri;
        }

        return rtrim($root, '/')."/$uri";
    }
}

<?php

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
 * @see https://github.com/barryvdh/laravel-debugbar/blob/master/src/JavascriptRenderer.php
 */
class JavascriptRenderer extends \DebugBar\JavascriptRenderer
{
    // Use XHR handler by default, instead of jQuery
    protected $ajaxHandlerBindToJquery = false;

    protected $ajaxHandlerBindToXHR = true;

    /**
     * Set the URL Generator.
     *
     * @param \Illuminate\Routing\UrlGenerator $url
     *
     * @deprecated
     */
    public function setUrlGenerator($url)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function renderHead()
    {
        $cssRoute = route('soar.bar.assets.css', [
            'v' => $this->getModifiedTime('css'),
        ]);

        $jsRoute = route('soar.bar.assets.js', [
            'v' => $this->getModifiedTime('js'),
        ]);

        $cssRoute = preg_replace('/\Ahttps?:/', '', $cssRoute);
        $jsRoute = preg_replace('/\Ahttps?:/', '', $jsRoute);

        $html = "<link rel='stylesheet' type='text/css' property='stylesheet' href='{$cssRoute}'>";
        $html .= "<script src='{$jsRoute}'></script>";

        if ($this->isJqueryNoConflictEnabled()) {
            $html .= '<script>jQuery.noConflict(true);</script>'."\n";
        }

        $html .= $this->getInlineHtml();

        return $html;
    }

    protected function getInlineHtml()
    {
        $html = '';

        foreach (['head', 'css', 'js'] as $asset) {
            foreach ($this->getAssets('inline_'.$asset) as $item) {
                $html .= $item."\n";
            }
        }

        return $html;
    }

    /**
     * Get the last modified time of any assets.
     *
     * @param string $type 'js' or 'css'
     *
     * @return int
     */
    protected function getModifiedTime($type)
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
     * Return assets as a string.
     *
     * @param string $type 'js' or 'css'
     *
     * @return string
     */
    public function dumpAssetsToString($type)
    {
        $files = $this->getAssets($type);

        $content = '';
        foreach ($files as $file) {
            $content .= file_get_contents($file)."\n";
        }

        return $content;
    }

    /**
     * Makes a URI relative to another.
     *
     * @param string|array $uri
     * @param string       $root
     *
     * @return array|string
     */
    protected function makeUriRelativeTo($uri, $root)
    {
        if (! $root) {
            return $uri;
        }

        if (is_array($uri)) {
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

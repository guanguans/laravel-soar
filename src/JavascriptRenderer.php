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

        $html = "<link rel='stylesheet' type='text/css' property='stylesheet' href='$cssRoute'>";
        $html .= <<<css
<style>
    div.phpdebugbar-header, a.phpdebugbar-restore-btn {
        background: #efefef url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBzdGFuZGFsb25lPSJubyI/PjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+PHN2ZyB0PSIxNjUwMjA2NzU1NzUzIiBjbGFzcz0iaWNvbiIgdmlld0JveD0iMCAwIDEwMjQgMTAyNCIgdmVyc2lvbj0iMS4xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHAtaWQ9IjY4MjMiIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCI+PGRlZnM+PHN0eWxlIHR5cGU9InRleHQvY3NzIj5AZm9udC1mYWNlIHsgZm9udC1mYW1pbHk6IGZlZWRiYWNrLWljb25mb250OyBzcmM6IHVybCgiLy9hdC5hbGljZG4uY29tL3QvZm9udF8xMDMxMTU4X3U2OXc4eWh4ZHUud29mZjI/dD0xNjMwMDMzNzU5OTQ0IikgZm9ybWF0KCJ3b2ZmMiIpLCB1cmwoIi8vYXQuYWxpY2RuLmNvbS90L2ZvbnRfMTAzMTE1OF91Njl3OHloeGR1LndvZmY/dD0xNjMwMDMzNzU5OTQ0IikgZm9ybWF0KCJ3b2ZmIiksIHVybCgiLy9hdC5hbGljZG4uY29tL3QvZm9udF8xMDMxMTU4X3U2OXc4eWh4ZHUudHRmP3Q9MTYzMDAzMzc1OTk0NCIpIGZvcm1hdCgidHJ1ZXR5cGUiKTsgfQo8L3N0eWxlPjwvZGVmcz48cGF0aCBkPSJNNTA2IDEzNS4zbDExOSAyNDEuMmMwLjggMS42IDIuMyAyLjcgNC4xIDNsMjY2LjEgMzguN2M0LjQgMC42IDYuMiA2LjEgMyA5LjJMNzA1LjYgNjE1LjFjLTEuMyAxLjItMS45IDMtMS42IDQuOEw3NDkuNSA4ODVjMC44IDQuNC0zLjkgNy44LTcuOSA1LjdsLTIzOC0xMjUuMWMtMS42LTAuOC0zLjUtMC44LTUgMGwtMjM4IDEyNS4xYy00IDIuMS04LjYtMS4zLTcuOS01LjdsNDUuNS0yNjUuMWMwLjMtMS44LTAuMy0zLjUtMS42LTQuOEwxMDQgNDI3LjRjLTMuMi0zLjEtMS40LTguNiAzLTkuMmwyNjYuMS0zOC43YzEuOC0wLjMgMy4zLTEuNCA0LjEtM2wxMTktMjQxLjJjMi00IDcuOC00IDkuOCAweiIgZmlsbD0iI0Y0QUUzRCIgcC1pZD0iNjgyNCI+PC9wYXRoPjxwYXRoIGQ9Ik0yNTggODk3LjNjLTIuNCAwLTQuNy0wLjctNi43LTIuMi0zLjUtMi42LTUuMy02LjgtNC41LTExLjJsNDUuNC0yNjQuOEw5OS44IDQzMS43Yy0zLjEtMy4xLTQuMi03LjUtMi45LTExLjcgMS40LTQuMiA0LjktNy4xIDkuMi03LjhMMzcyIDM3My42bDExOC45LTI0MC45YzEuOS0zLjkgNS45LTYuNCAxMC4yLTYuNCA0LjQgMCA4LjMgMi40IDEwLjIgNi40bDExOC45IDI0MC45TDg5NiA0MTIuMmM0LjMgMC42IDcuOSAzLjYgOS4yIDcuOCAxLjQgNC4yIDAuMiA4LjYtMi45IDExLjdMNzEwIDYxOS4yIDc1NS40IDg4NGMwLjcgNC4zLTEgOC42LTQuNSAxMS4yLTMuNSAyLjYtOC4xIDIuOS0xMiAwLjlsLTIzNy44LTEyNS0yMzcuOCAxMjVjLTEuNiAwLjctMy41IDEuMi01LjMgMS4yek0xMDkuMSA0MjMuOWwxOTEuNyAxODYuOWMyLjcgMi42IDMuOSA2LjQgMy4zIDEwLjFsLTQ1LjMgMjYzLjkgMjM3LTEyNC42YzMuMy0xLjcgNy4zLTEuOCAxMC42IDBsMjM3IDEyNC42LTQ1LjMtMjYzLjljLTAuNi0zLjcgMC42LTcuNSAzLjMtMTAuMWwxOTEuNy0xODYuOS0yNjUtMzguNWMtMy43LTAuNS02LjktMi45LTguNi02LjJMNTAxLjEgMTM5LjEgMzgyLjYgMzc5LjJjLTEuNyAzLjQtNC45IDUuNy04LjYgNi4ybC0yNjQuOSAzOC41eiIgZmlsbD0iIzIzMjMyMyIgcC1pZD0iNjgyNSI+PC9wYXRoPjxwYXRoIGQ9Ik04NzcuMiAyMTQuNWwxNi4xIDM1LjMgMjkuNCAxOS4zLTI5LjQgMTkuNC0xNi4xIDM1LjMtMTYuMS0zNS4zLTI5LjQtMTkuNCAyOS40LTE5LjN6IiBmaWxsPSIjRjRBRTNEIiBwLWlkPSI2ODI2Ij48L3BhdGg+PHBhdGggZD0iTTg3Ny4yIDMyNy44Yy0xLjYgMC0zLTAuOS0zLjYtMi4zTDg1OCAyOTEuMmwtMjguNC0xOC43Yy0xLjEtMC43LTEuOC0yLTEuOC0zLjNzMC43LTIuNiAxLjgtMy4zbDI4LjQtMTguNyAxNS42LTM0LjNjMC42LTEuNCAyLjEtMi4zIDMuNi0yLjNzMyAwLjkgMy42IDIuM2wxNS42IDM0LjMgMjguNCAxOC43YzEuMSAwLjcgMS44IDIgMS44IDMuM3MtMC43IDIuNi0xLjggMy4zbC0yOC40IDE4LjctMTUuNiAzNC4zYy0wLjYgMS40LTIgMi4zLTMuNiAyLjN6TTgzOSAyNjkuMWwyNC4zIDE2YzAuNiAwLjQgMS4xIDEgMS40IDEuN2wxMi40IDI3LjMgMTIuNC0yNy4zYzAuMy0wLjcgMC44LTEuMyAxLjQtMS43bDI0LjMtMTYtMjQuMy0xNmMtMC42LTAuNC0xLjEtMS0xLjQtMS43bC0xMi40LTI3LjMtMTIuNCAyNy4zYy0wLjMgMC43LTAuOCAxLjMtMS40IDEuN2wtMjQuMyAxNnoiIGZpbGw9IiMyMzIzMjMiIHAtaWQ9IjY4MjciPjwvcGF0aD48L3N2Zz4=)  no-repeat 5px 4px / 20px 20px;
    }
</style>
css;

        $html .= "<script src='$jsRoute'></script>";

        if ($this->isJqueryNoConflictEnabled()) {
            $html .= '<script>jQuery.noConflict(true);</script>'."\n";
        }

        $html .= $this->getInlineHtml();

        return $html;
    }

    /**
     * Get inline HTML.
     */
    protected function getInlineHtml(): string
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
     * @param string|null $type 'js' or 'css'
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
     * Return assets as a string.
     *
     * @param string|null $type 'js' or 'css'
     */
    public function dumpAssetsToString(?string $type): string
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
     * @param string|string[] $uri
     * @param string          $root
     *
     * @return string|string[]
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

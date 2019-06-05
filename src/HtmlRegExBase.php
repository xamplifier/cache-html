<?php

namespace Xamplifier\CacheHtml;

class HtmlRegExBase
{
    protected $pattern;

    protected $replacement;

    public function __contruct(string $p = "", string $r = "")
    {
        if (empty($p) === false) {
            $this->pattern = $p;
        }

        if (empty($r) === false) {
            $this->replacement = $r;
        }
    }

    public function getPattern() : string
    {
        return $this->pattern;
    }

    public function getReplacement() : string
    {
        return $this->replacement;
    }
}

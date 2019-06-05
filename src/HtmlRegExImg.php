<?php

namespace Xamplifier\CacheHtml;

class HtmlRegExImg extends HtmlRegExBase
{
    protected $pattern = '#<img(.*)src=\"(?!http|https|\/\/)(.*)\"(.*)>#m';

    protected $replacement = "<img$1src=\"%%baseUrl%%$2\"$3>";
}

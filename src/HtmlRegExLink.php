<?php

namespace Xamplifier\CacheHtml;

class HtmlRegExLink extends HtmlRegExBase
{
    protected $pattern = '#<link(.*)href=\"(?!http|https|\/\/)(.*)\"(.*)>#m';

    protected $replacement = "<link$1href=\"%%baseUrl%%$2\"$3>";
}

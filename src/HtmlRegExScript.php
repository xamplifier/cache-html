<?php

namespace Xamplifier\CacheHtml;

class HtmlRegExScript extends HtmlRegExBase
{
    protected $pattern = '#<script(.*)src=\"(?!http|https|\/\/)(.*)\"(.*)>#m';

    protected $replacement = "<script$1src=\"%%baseUrl%%$2\"$3>";
}

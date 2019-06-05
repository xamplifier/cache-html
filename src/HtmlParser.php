<?php

namespace Xamplifier\CacheHtml;

use \preg_replace;

final class HtmlParser
{
    protected $content;

    protected $baseUrl;

    protected $url;

    protected $regExs = [];

    public function __construct(string $url, string $baseUrl)
    {
        $this->url = $url;

        $this->baseUrl = $baseUrl;

        $this->setContent();

        $this->regExs = [
            new HtmlRegExImg,
            new HtmlRegExLink,
            new HtmlRegExScript
        ];

        $this->runRegExs();
    }

    public function getContent() : string
    {
        return $this->content;
    }

    private function setContent() : void
    {
        $this->content = file_get_contents($this->url);
    }

    private function runRegExs() : void
    {
        foreach ($this->regExs as $re) {
            $replacement = str_replace(
                '%%baseUrl%%',
                $this->baseUrl,
                $re->getReplacement()
            );

            $this->content = preg_replace(
                $re->getPattern(),
                $replacement,
                $this->content
            );
        }
    }
}

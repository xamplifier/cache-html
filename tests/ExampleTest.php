<?php

namespace Xamplifier\CacheHtml\Test;

use PHPUnit\Framework\TestCase;
use Xamplifier\CacheHtml\HtmlParser;
use Xamplifier\CacheHtml\FilesystemCache;

class ExampleTest extends TestCase
{

    public function setUp() : void
    {
        $c = new FilesystemCache([
            'path' => __DIR__ . DIRECTORY_SEPARATOR . 'cache-storage'
        ]);

        $c->clear();
    }

    public function testRun() : void
    {
        $url = "https://admin.xamplifier.com/reviews/hw_v3.cfm?token=3tPZaJyKbpFt6ilqQtAY2QvAAUGz70oW37Q74JTYBJI2EkgOzKVmucWhmD5u&businessunit=5c2e8d6203c9196cf074cd63&abbreviation=200&reviewcount=4&customTitle=%3Cleft%3E%3Cstrong%3EHonolulu,%20HI%3C/strong%3E";
        $baseUrl = "https://admin.xamplifier.com/reviews/";

        $c = new FilesystemCache([
            'path' => __DIR__ . DIRECTORY_SEPARATOR . 'cache-storage'
        ]);

        if ($c->has($url)) {
            $content = $c->get($url);
        } else {
            $hp = new HtmlParser($url, $baseUrl);
            $c->set($url, $hp->getContent());
        }

    }
}

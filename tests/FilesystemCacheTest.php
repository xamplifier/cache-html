<?php

namespace Xamplifier\CacheHtml\Test;

use PHPUnit\Framework\TestCase;
use Xamplifier\CacheHtml\FilesystemCache;

class FilesystemCacheTest extends TestCase
{
    public function setUp() : void
    {
        $this->cacheDir = __DIR__ . DIRECTORY_SEPARATOR . 'cache-storage';
    }
    public function testPoolIsBeingBuilt() : void
    {
        $c = new FilesystemCache([
            'path' => $this->cacheDir
        ]);

        $pool = $c->getPool();
        $this->assertTrue(is_array($pool));

        $this->assertTrue(count($pool) > 0);
    }

    public function testPoolFileExists() : void
    {
        $c = new FilesystemCache([
            'path' => $this->cacheDir
        ]);

        $pool = $c->getPool();
        foreach ($pool as $cachedFile) {
            $fileName = $this->cacheDir . DIRECTORY_SEPARATOR . $cachedFile;
            $this->assertFileExists($fileName);
        }
    }

    public function testStoreCachedFile()
    {
        $htmlContent = <<<EOT
<!doctype html>
<html>
    <head></head>
    <body><h1>Dummy HTML</h1></body>
</html>
EOT;
        $site = 'http://xamplifier.com/a-dummy-page';
        $c = new FilesystemCache([
            'path' => $this->cacheDir
        ]);
        $c->set($site, $htmlContent);

        $this->assertTrue($c->has($site));
        //Check it is already added to pool
        $this->assertContains($c->genKey($site), $c->getPool());
    }

    public function testGetCachedFile()
    {
        $htmlContent = <<<EOT
<!doctype html>
<html>
    <head></head>
    <body><h1>Dummy HTML</h1></body>
</html>
EOT;
        $site = 'http://xamplifier.com/a-dummy-page';
        $c = new FilesystemCache([
            'path' => $this->cacheDir
        ]);
        $c->set($site, $htmlContent);
        $content = $c->get($site);

        $this->assertTrue(is_string($content));
    }
}

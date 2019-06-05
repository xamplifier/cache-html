<?php

namespace Xamplifier\CacheHtml;

use \FilesystemIterator;
use Psr\SimpleCache\CacheInterface;

final class FilesystemCache implements CacheInterface
{
    CONST FORMAT = '.html';

    protected $config = [
        // 'duration' => 3600,
        'path' => null,
    ];

    protected $pool = [];

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->setPool();
    }

    public function genKey(string $key) :string
    {
        return md5($key) . self::FORMAT;
    }

    public function setPool() :void
    {
        $this->pool = [];
        $it = new FilesystemIterator($this->config['path']);

        foreach ($it as $file) {
            if (!$file->isFile() && !$file->isReadable()) {
                continue;
            }

            array_push($this->pool, $file->getFileName());
        }
    }

    public function getPool() :array
    {
        return $this->pool;
    }

    public function get($key, $default = null)
    {
        $key = $this->genKey($key);

        if (!in_array($key, $this->pool)) {
            return null;
        }

        $content = file_get_contents($this->config['path'] . DIRECTORY_SEPARATOR . $key);

        return $content;
    }

    public function set($key, $value, $ttl = null) :void
    {
        $key = $this->genKey($key);

        $fileName = $this->config['path'] . DIRECTORY_SEPARATOR . $key;
        file_put_contents($fileName, $value);

        $this->setPool();
    }

    public function has($key)
    {
        $key = $this->genKey($key);

        return in_array($key, $this->pool);
    }

    public function delete($key)
    {
        //
    }

    public function clear()
    {
        foreach ($this->pool as $index => $cachedFile) {
            unlink($this->config['path'] . DIRECTORY_SEPARATOR . $cachedFile);
            unset($this->pool[$index]);
        }
    }


    public function getMultiple($keys, $default = null) {}
    public function setMultiple($values, $ttl = null) {}
    public function deleteMultiple($keys) {}
}
